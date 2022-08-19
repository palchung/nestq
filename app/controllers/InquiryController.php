<?php

use Repository\InquiryRepository;
use Repository\AdminDocumentationRepository;

class InquiryController extends BaseController {

    protected $layout = "layout.main";
    protected $inquiry;
    protected $adminDocumentation;

    public function __construct(InquiryRepository $inquiry, AdminDocumentationRepository $adminDocumentation)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('only' => array('getAdd')));
        $this->inquiry = $inquiry;
        $this->adminDocumentation = $adminDocumentation;
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

    public function getGuide($document_id = null, $toedit = null)
    {
        $edit = false;
        $categories = $this->adminDocumentation->loadDocumentActiveCategory('category');
        $subcategories = $this->adminDocumentation->loadDocumentActiveSubCategory();
        $documents = $this->adminDocumentation->loadDocumentsTitle();

        if ($document_id == null)
        {
            $guide = null;

        } else
        {
            $guide = $this->adminDocumentation->loadDocumentById($document_id);
        }

        $this->layout->content = View::make('inquiry.guide')
            ->with('subcategories', $subcategories)
            ->with('categories', $categories)
            ->with('documents', $documents)
            ->with('edit', $edit)
            ->with('guide', $guide);


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
