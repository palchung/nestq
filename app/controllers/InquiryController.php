<?php

use Repository\InquiryRepository;

class InquiryController extends BaseController {

    protected $layout = "layout.main";
    protected $inquiry;

    public function __construct(InquiryRepository $inquiry)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('only' => array('getAdd')));
        $this->inquiry = $inquiry;
    }

    public function getAbout()
    {
        $this->layout->content = View::make('inquiry.about');
    }

    public function getTerms()
    {
        $this->layout->content = View::make('inquiry.terms');
    }

    public function getSearch()
    {
        $this->layout->content = View::make('inquiry.search');
    }

    public function getGuide()
    {
        $category = $this->inquiry->loadDocumentActiveCategory('category');
        //$subcategory = $this->inquiry->loadDocumentActiveCategory('subcategory');
        $this->layout->content = View::make('inquiry.guide')
            ->with('categories', $category);
        //->with('subcategories',$subcategory);
    }

    public function getCategory($categoryId)
    {

        $category = $this->inquiry->loadDocumentActiveCategory('category');
        $subcategory = $this->inquiry->loadDocumentActiveSubCategoryById($categoryId);
        $this->layout->content = View::make('inquiry.guide')
            ->with('categories', $category)
            ->with('subcategories', $subcategory);
    }


    public function getDocument($categoryId, $subcategoryId)
    {

        $category = $this->inquiry->loadDocumentActiveCategory('category');
        $subcategory = $this->inquiry->loadDocumentActiveSubCategoryById($categoryId);
        $document = $this->inquiry->loadDocument($subcategoryId);

        $this->layout->content = View::make('inquiry.guide')
            ->with('documents', $document)
            ->with('categories', $category)
            ->with('subcategories', $subcategory);
    }


}
