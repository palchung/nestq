<?php

use Repository\AdminDocumentationRepository;

class AdminDocumentationController extends BaseController {

    protected $layout = "layout.backoffice";
    protected $adminDocumentation;

    public function __construct(AdminDocumentationRepository $adminDocumentation)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('on' => array('post', 'get')));
        $this->adminDocumentation = $adminDocumentation;
    }

    public function getIndex($document_id = null, $toedit = null)
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

        if ($toedit == 'edit')
        {
            $edit = true;
        }


        $this->layout->content = View::make('backoffice.documentation')
            ->with('subcategories', $subcategories)
            ->with('categories', $categories)
            ->with('documents', $documents)
            ->with('edit', $edit)
            ->with('guide', $guide);


    }


    public function getNew($activecategory_id = null)
    {

        $activecategories = $this->adminDocumentation->loadDocumentActiveCategory('category');

        if ($activecategory_id == null)
        {
            $subcategories = null;
        } else
        {
            $subcategories = $this->adminDocumentation->loadDocumentActiveCategory('subcategory', $activecategory_id);
        }

        $this->layout->content = View::make('backoffice.new')
            ->with('category_id', $activecategory_id)
            ->with('activecategories', $activecategories)
            ->with('subcategories', $subcategories);

    }


    public function postEditdocumentation()
    {
        $document_id = Input::get('documentId');
        $title = Input::get('title');
        $content = Input::get('content');

        if ($content == '')
        {
            return Redirect::to('adminDocumentation/index/' . $document_id)->with('flash_message', 'nothing inputed');
        } else{

            $update = $this->adminDocumentation->updateDocumentation($document_id, $title, $content);

            if ($update == 'success'){
                return Redirect::to('adminDocumentation/index/' . $document_id);
            }else{
                return Redirect::to('adminDocumentation/index/' . $document_id)->with('flash_message', 'cant update');
            }
        }
    }


    public function postCreatedocumentation()
    {
        $content = Input::get('content');
        $category_id = Input::get('categoryId');
        if ($content == '')
        {
            return Redirect::to('adminDocumentation/new/' . $category_id)->with('flash_message', 'nothing inputed');
        } else
        {

            $title = Input::get('title');
            $subcategoryId = Input::get('subcategoryId');
            $create = $this->adminDocumentation->createDocumentation($subcategoryId, $title, $content);
            if ($create == 'success')
            {
                return Redirect::to('adminDocumentation/new/' . $category_id)->with('flash_message', 'saved');
            } else
            {
                return Redirect::to('adminDocumentation/new/' . $category_id)->with('flash_message', 'category cant create, some error');
            }
        }
    }


    public function getCategory()
    {

        $categories = $this->adminDocumentation->loadDocumentCategory('category');

        $this->layout->content = View::make('backoffice.documentationcategory')
            ->with('categories', $categories);
    }


    public function getSubcategory($activecategory_id = null)
    {

        $activecategories = $this->adminDocumentation->loadDocumentActiveCategory('category');


        if ($activecategory_id == null)
        {

            $subcategories = null;
            $this->layout->content = View::make('backoffice.documentationsubcategory')
                ->with('activecategories', $activecategories)
                ->with('subcategories', $subcategories);

        } else
        {
            $subcategories = $this->adminDocumentation->loadDocumentCategory('subcategory', $activecategory_id);
            $category_id = $activecategory_id;
            $this->layout->content = View::make('backoffice.documentationsubcategory')
                ->with('activecategories', $activecategories)
                ->with('category_id', $category_id)
                ->with('subcategories', $subcategories);
        }
    }


    public function postCreatecategory()
    {
        $category = Input::get('category');
        if ($category == '')
        {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else
        {
            $create = $this->adminDocumentation->createDocumentCategory($category);
            if ($create == 'success')
            {
                return Redirect::to('adminDocumentation/category/');
            } else
            {
                return Redirect::to('adminDocumentation/category/')->with('flash_message', 'category cant create, some error');
            }
        }
    }

    public function postCreatesubcategory()
    {
        $subcategory = Input::get('subcategory');
        if ($subcategory == '')
        {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else
        {

            $categoryId = Input::get('categoryId');
            $create = $this->adminDocumentation->createDocumentSubCategory($subcategory, $categoryId);
            if ($create == 'success')
            {
                return Redirect::to('adminDocumentation/subcategory/' . $categoryId);
            } else
            {
                return Redirect::to('adminDocumentation/subcategory/' . $categoryId)->with('flash_message', 'category cant create, some error');
            }
        }
    }

    public function postEditcategory()
    {
        $category = Input::get('category');
        if ($category == '')
        {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else
        {
            $id = Input::get('id');
            $active = Input::get('active');
            $edit = $this->adminDocumentation->editDocumentCategory($id, $category, $active);
            if ($edit == 'success')
            {
                return Redirect::to('adminDocumentation/category/');
            } else
            {
                return Redirect::to('adminDocumentation/category/')->with('flash_message', 'Category cant edit, some error');
            }
        }
    }

    public function postEditsubcategory()
    {
        $subcategory = Input::get('subcategory');
        if ($subcategory == '')
        {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'nothing inputed');
        } else
        {
            $id = Input::get('id');
            $categoryId = Input::get('categoryId');
            $active = Input::get('active');
            $edit = $this->adminDocumentation->editDocumentSubCategory($id, $subcategory, $categoryId, $active);
            if ($edit == 'success')
            {
                return Redirect::to('adminDocumentation/subcategory/' . $categoryId);
            } else
            {
                return Redirect::to('adminDocumentation/subcategory/' . $categoryId)->with('flash_message', 'Category cant edit, some error');
            }
        }
    }

    public function postDeletecategory()
    {
        $id = Input::get('id');
        $delete = $this->adminDocumentation->deleteCategory($id);
        if ($delete == 'success')
        {
            return Redirect::to('adminDocumentation/category/');
        } else
        {
            return Redirect::to('adminDocumentation/category/')->with('flash_message', 'Category cant delete, some error');
        }
    }

    public function postDeletedocument()
    {
        $document_id = Input::get('documentId');
        $delete = $this->adminDocumentation->deleteDocument($document_id);
        if ($delete == 'success')
        {
            return Redirect::to('adminDocumentation/index/')->with('flash_message', 'Document deleted');
        } else
        {
            return Redirect::to('adminDocumentation/index/')->with('flash_message', 'Category cant delete, some error');
        }
    }





    public function postDeletesubcategory()
    {
        $id = Input::get('id');
        $category_id = Input::get('categoryId');
        $delete = $this->adminDocumentation->deleteSubCategory($id);
        if ($delete == 'success')
        {
            return Redirect::to('adminDocumentation/subcategory/' . $category_id);
        } else
        {
            return Redirect::to('adminDocumentation/subcategory/' . $category_id)->with('flash_message', 'Sub-Category cant delete, some error');
        }
    }


}
