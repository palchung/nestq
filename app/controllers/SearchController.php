<?php

use Repository\SearchRepository;
use Repository\PropertyRepository;

class SearchController extends BaseController {

    protected $layout = "layout.main";
    protected $search;
    protected $property;


    public function __construct(SearchRepository $search, PropertyRepository $property)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('only' => array('getAdd')));
        $this->search = $search;
        $this->property = $property;
    }

    public function getReset()
    {
        Session::flush();

        return Redirect::to('/');

    }



    public function getProperty($sort = null)
    {

        $validator = Validator::make(Input::all(), Search::$SearchRules);
        if ($validator->passes())
        {

            $this->search->cacheInput();
            $querystring = $this->search->storeQuerystring();


            if($sort){
                $qstring = Session::get('querystring');
            }else{
                $qstring = $querystring;
                Session::put('querystring', $querystring);
            }

            $result = $this->search->searchProperty($qstring, $sort);

            $properties = $result->paginate(Config::get('nestq.SEARCH_NOS_OF_RESULT'));

            if (sizeof($properties) == 0)
            {
                return Redirect::to('inquiry/search')->with('flash_message', '沒有相配的物業資訊');

            } else
            {

                $photos = [];
                foreach ($properties as $property)
                {
                    $photos[$property->property_id] = $this->property->loadPropertyThumbnail($property->property_photo);
                }

                $this->layout->content = View::make('property.list')
                ->with('properties', $properties)
                ->with('photos', $photos)
                ->with('querystrings', $querystring);

            }
        } else
        {
            return Redirect::to('inquiry/search')->with('flash_message', '找不到物業資訊');
        }
    }

}
