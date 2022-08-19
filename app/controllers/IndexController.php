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


        // $this->layout->content = View::make('frontpage.index')
        // ->with('frontpage', $frontpage);

        $this->layout->content = View::make('frontpage.index');

    }

}
