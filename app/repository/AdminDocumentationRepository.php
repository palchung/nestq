<?php

namespace Repository;

use Input;
use DB;
use DocumentCategory;
use DocumentSubCategory;
use Documentation;

class AdminDocumentationRepository {

    public function loadDocumentCategory($whatToLoad = null, $activecategory_id = null)
    {
        if ($whatToLoad == 'category')
        {
            $list = DocumentCategory::all();
        } elseif ($whatToLoad == 'subcategory')
        {

            $list = DocumentSubCategory::where('category_id', '=', $activecategory_id)->get();
        }

        return $list;
    }

    public function loadDocumentActiveCategory($whatToLoad = null, $activecategory_id = null)
    {
        if ($whatToLoad == 'category')
        {
//            $list = DB::table('documentcategory')->where('active', '=', 1)->orderBy('category', 'asc')->lists('category', 'id');
            $list = DB::table('documentcategory')->where('active', '=', 1)->orderBy('category', 'asc')->get();

        } elseif ($whatToLoad == 'subcategory')
        {
            $list = DB::table('documentsubcategory')
                ->where('active', '=', 1)
                ->where('category_id', '=', $activecategory_id)
                ->orderBy('sub_category', 'asc')
                ->lists('sub_category', 'id', 'category_id');
        }

        return $list;
    }


    public function loadDocumentActiveSubCategory()
    {
        $list = DB::table('documentsubcategory')->where('active', '=', 1)->orderBy('sub_category', 'asc')->get();

        return $list;
    }

    public function loadDocuments()
    {
        $list = Documentation::all();

        return $list;
    }

    public function loadDocumentsTitle()
    {
        $list = DB::table('documentation')
            ->select([
                'id as id',
                'title as title',
                'sub_category_id as sub_category_id'
            ])
            ->get();

        return $list;
    }

    public function loadDocumentById($document_id)
    {

        $document = DB::table('documentation')
            ->join('documentsubcategory', 'documentsubcategory.id', '=', 'documentation.sub_category_id')
            ->join('documentcategory', 'documentcategory.id', '=', 'documentsubcategory.category_id')
            ->select([
                'documentation.id as id',
                'documentation.title as title',
                'documentation.content as content',
                'documentation.updated_at as updated_at',
                'documentsubcategory.sub_category as subcategory',
                'documentcategory.category as category',
            ])
            ->where('documentation.id' ,'=', $document_id)
            ->get();

        return $document[0];

    }


    public function createDocumentation($subcategory_id = null, $title = null, $content = null)
    {

        $document = new Documentation;
        $document->sub_category_id = $subcategory_id;
        $document->title = $title;
        $document->content = $content;
        $document->save();

        return 'success';

    }

    public function updateDocumentation($document_id = null, $title = null, $content = null)
    {
        $document = Documentation::find($document_id);
        $document->title = $title;
        $document->content = $content;
        $document->save();

        return 'success';
    }





    public function createDocumentCategory($category = null)
    {
        $document = new DocumentCategory;
        $document->category = $category;
        $document->active = 1;
        $document->save();

        return 'success';
    }

    public function createDocumentSubCategory($subcategory = null, $category_id = null)
    {
        $document = new DocumentSubCategory;
        $document->sub_category = $subcategory;
        $document->category_id = $category_id;
        $document->active = 1;
        $document->save();

        return 'success';
    }

    public function editDocumentCategory($id = null, $category = null, $active = null)
    {
        $document = DocumentCategory::find($id);
        $document->category = $category;
        $document->active = $active;
        $document->save();

        return 'success';
    }

    public function editDocumentSubCategory($id = null, $subcategory = null, $category_id = null, $active = null)
    {
        $document = DocumentSubCategory::find($id);
        $document->sub_category = $subcategory;
        $document->category_id = $category_id;
        $document->active = $active;
        $document->save();

        return 'success';
    }

    public function deleteCategory($id = null)
    {
        $document = DocumentCategory::find($id);
        $document->delete();

        return 'success';
    }

    public  function deleteDocument($id = null)
    {
        $document = Documentation::find($id);
        $document->delete();

        return 'success';
    }



    public function deleteSubCategory($id = null)
    {
        $document = DocumentSubCategory::find($id);
        $document->delete();

        return 'success';
    }

}
