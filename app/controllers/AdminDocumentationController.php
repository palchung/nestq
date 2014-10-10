<?php

use Repository\AdminDocumentationRepository;

class AdminDocumentationController extends BaseController {

    protected $layout = "layout.backoffice";
    protected $adminDocumentation;

    public function __construct(AdminDocumentationRepository $adminDocumentation) {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('on' => array('post', 'get')));
        $this->adminDocumentation = $adminDocumentation;
    }

    public function getIndex() {

        $this->layout->content = View::make('backoffice.documentation');
    }

    public function getNew() {

        $subcategories = $this->adminDocumentation->loadDocumentActiveCategory('subcategory');
        $this->layout->content = View::make('backoffice.new')
            ->with('subcategories', $subcategories);
    }

    public function getCategory() {

        $categories = $this->adminDocumentation->loadDocumentCategory('category');
        $activecategories = $this->adminDocumentation->loadDocumentActiveCategory('category');
        $subcategories = $this->adminDocumentation->loadDocumentCategory('subcategory');

        $this->layout->content = View::make('backoffice.documentationcategory')
            ->with('categories', $categories)
            ->with('activecategories', $activecategories)
            ->with('subcategories', $subcategories);
    }

    public function postCreateCategory() {
        $category = Input::get('category');
        if ($category == '') {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else {
            $create = $this->adminDocumentation->createDocumentCategory($category);
            if ($create == 'success') {
                return Redirect::to('adminDocumentation/category/');
            } else {
                return Redirect::to('adminDocumentation/category/')->with('flash_message', 'category cant create, some error');
            }
        }
    }

    public function postCreateSubCategory() {
        $subcategory = Input::get('subcategory');
        if ($subcategory == '') {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else {

            $categoryId = Input::get('categoryId');
            $create = $this->adminDocumentation->createDocumentSubCategory($subcategory, $categoryId);
            if ($create == 'success') {
                return Redirect::to('adminDocumentation/category/');
            } else {
                return Redirect::to('adminDocumentation/category/')->with('flash_message', 'category cant create, some error');
            }
        }
    }

    public function postEditCategory() {
        $category = Input::get('category');
        if ($category == '') {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else {
            $id = Input::get('id');
            $active = Input::get('active');
            $edit = $this->adminDocumentation->editDocumentCategory($id, $category, $active);
            if ($edit == 'success') {
                return Redirect::to('adminDocumentation/category/');
            } else {
                return Redirect::to('adminDocumentation/category/')->with('flash_message', 'Category cant edit, some error');
            }
        }
    }

    public function postEditSubCategory() {
        $subcategory = Input::get('subcategory');
        if ($subcategory == '') {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else {
            $id = Input::get('id');
            $categoryId = Input::get('categoryId');
            $active = Input::get('active');
            $edit = $this->adminDocumentation->editDocumentSubCategory($id, $subcategory, $categoryId, $active);
            if ($edit == 'success') {
                return Redirect::to('adminDocumentation/category/');
            } else {
                return Redirect::to('adminDocumentation/category/')->with('flash_message', 'Category cant edit, some error');
            }
        }
    }

    public function postDeleteCategory() {
        $id = Input::get('id');
        $delete = $this->adminDocumentation->deleteCategory($id);
        if ($delete == 'success') {
            return Redirect::to('adminDocumentation/category/');
        } else {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'Category cant delete, some error');
        }
    }

    public function postDeleteSubCategory() {
        $id = Input::get('id');
        $delete = $this->adminDocumentation->deleteSubCategory($id);
        if ($delete == 'success') {
            return Redirect::to('adminDocumentation/category/');
        } else {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'Sub-Category cant delete, some error');
        }
    }

    public function postCreateDocumentation() {
        $content = Input::get('content');
        if ($content == '') {
            return Redirect::to('adminDocumentation/new/')->with('flash_message', 'nothing inputed');
        } else {

            $title = Input::get('title');
            $subcategoryId = Input::get('subcategoryId');
            $create = $this->adminDocumentation->createDocumentation($subcategoryId, $title, $content);
            if ($create == 'success') {
                return Redirect::to('adminDocumentation/index/');
            } else {
                return Redirect::to('adminDocumentation/new/')->with('flash_message', 'category cant create, some error');
            }
        }
    }

}
