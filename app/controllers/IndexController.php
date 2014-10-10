<?php

use Repository\IndexRepository;

class IndexController extends BaseController {

        protected $layout = "layout.main";
        protected $index;

        public function __construct(IndexRepository $index) {
                //$this->beforeFilter('csrf', array('on' => 'post'));
                //$this->beforeFilter('auth', array('only' => array('getAdd')));
                $this->index = $index;
        }

        public function indexAction() {

                $this->layout->content = View::make('frontpage.index');

                $territory = $this->index->loadTerritoryList();
                $region = $this->index->loadRegionList();
                $category = $this->index->loadCategoryList();
                $facility = $this->index->loadFacilityList();
                $this->layout->searchbox = View::make('frontpage.searchbox')
                ->with('territories', $territory)
                ->with('regions', $region)
                ->with('categories', $category)
                ->with('facilities', $facility);
        }

}
