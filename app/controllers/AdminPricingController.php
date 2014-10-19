<?php

use Repository\AdminPricingRepository;

class AdminPricingController extends BaseController {

    protected $layout = "layout.backoffice";
    protected $adminPricing;

    public function __construct(AdminPricingRepository $adminPricing)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('on' => array('post', 'get')));
        $this->adminPricing = $adminPricing;
    }

    public function getIndex()
    {
        $items = $this->adminPricing->loadProducts();
        $schemes = $this->adminPricing->loadSchemes();
        $this->layout->content = View::make('backoffice.pricing')
            ->with('items', $items)
            ->with('schemes', $schemes);
    }

    public function postEdit()
    {
        $item = Input::get('item');
        if ($item == '')
        {
            return Redirect::to('adminPricing/index/')->with('flash_message', 'nothing inputed');
        } else
        {
            $id = Input::get('id');
            $price = Input::get('price');
            $package = Input::get('package');
            $active = Input::get('active');
            $edit = $this->adminPricing->editPricepage($id, $item, $price, $package, $active);
            if ($edit == 'success')
            {
                return Redirect::to('adminPricing/index/');
            } else
            {
                return Redirect::to('adminPricing/index/')->with('flash_message', 'Items cant edit, some error');
            }
        }
    }

    public function postDelete()
    {
        $id = Input::get('id');
        $delete = $this->adminPricing->deletePricepageItem($id);
        if ($delete == 'success')
        {
            return Redirect::to('adminPricing/index/');
        } else
        {
            return Redirect::to('adminPricing/index/')->with('flash_message', 'Item cant delete, some error');
        }
    }

    public function postCreate()
    {
        $item = Input::get('item');
        if ($item == '')
        {
            return Redirect::to('adminPricing/index/')->with('flash_message', 'nothing inputed');
        } else
        {
            $price = Input::get('price');
            $package = Input::get('package');
            $create = $this->adminPricing->createPricepageItem($item, $price, $package);
            if ($create == 'success')
            {
                return Redirect::to('adminPricing/index/');
            } else
            {
                return Redirect::to('adminPricing/index/')->with('flash_message', 'item cant create, some error');
            }
        }
    }

    public function postEditscheme()
    {
        $scheme = Input::get('scheme');
        if ($scheme == '')
        {
            return Redirect::to('adminPricing/index/')->with('flash_message', 'nothing inputed');
        } else
        {
            $id = Input::get('id');
            $multi = Input::get('multi');
            $active = Input::get('active');
            $period = Input::get('period');
            $edit = $this->adminPricing->editScheme($id, $scheme, $multi, $active, $period);
            if ($edit == 'success')
            {
                return Redirect::to('adminPricing/index/');
            } else
            {
                return Redirect::to('adminPricing/index/')->with('flash_message', 'Schemes cant edit, some error');
            }
        }
    }

    public function postDeletescheme()
    {
        $id = Input::get('id');
        $delete = $this->adminPricing->deleteScheme($id);
        if ($delete == 'success')
        {
            return Redirect::to('adminPricing/index/');
        } else
        {
            return Redirect::to('adminPricing/index/')->with('flash_message', 'Schemes cant delete, some error');
        }
    }

    public function postCreatescheme()
    {
        $scheme = Input::get('scheme');
        if ($scheme == '')
        {
            return Redirect::to('adminPricing/index/')->with('flash_message', 'nothing inputed');
        } else
        {
            $multi = Input::get('multi');
            $period = Input::get('period');
            $create = $this->adminPricing->createScheme($scheme, $multi, $period);
            if ($create == 'success')
            {
                return Redirect::to('adminPricing/index/');
            } else
            {
                return Redirect::to('adminPricing/index/')->with('flash_message', 'scheme cant create, some error');
            }
        }
    }

}
