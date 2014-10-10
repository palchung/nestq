<?php

namespace Repository;

use Input;
use DB;
use DocumentCategory;
use DocumentSubCategory;
use Documentation;

class AdminDocumentationRepository {

    public function loadDocumentCategory($whatToLoad = null) {
        if ($whatToLoad == 'category') {
            $list = DocumentCategory::all();
        } elseif ($whatToLoad == 'subcategory') {
            $list = DocumentSubCategory::all();
        }
        return $list;
    }

    public function loadDocumentActiveCategory($whatToLoad = null) {
        if ($whatToLoad == 'category') {
            $list = DB::table('documentcategory')->where('active', '=', 1)->orderBy('category', 'asc')->lists('category', 'id');
        } elseif ($whatToLoad == 'subcategory') {
            $list = DB::table('documentsubcategory')->where('active', '=', 1)->orderBy('sub_category', 'asc')->lists('sub_category', 'id', 'category_id');
        }
        return $list;
    }

    public function createDocumentation($subcategory_id = null, $title = null, $content = null){
        
        $document = new Documentation;
        $document->sub_category_id = $subcategory_id;
        $document->title = $title;
        $document->content = $content;
        $document->save();
        return 'success';       
        
    }
    
    
    
    public function createDocumentCategory($category = null) {
        $document = new DocumentCategory;
        $document->category = $category;
        $document->active = 1;
        $document->save();
        return 'success';
    }

    public function createDocumentSubCategory($subcategory = null, $category_id = null) {
        $document = new DocumentSubCategory;
        $document->sub_category = $subcategory;
        $document->category_id = $category_id;
        $document->active = 1;
        $document->save();
        return 'success';
    }

    public function editDocumentCategory($id = null, $category = null, $active = null) {
        $document = DocumentCategory::find($id);
        $document->category = $category;
        $document->active = $active;
        $document->save();
        return 'success';
    }

    public function editDocumentSubCategory($id = null, $subcategory = null, $category_id = null, $active = null) {
        $document = DocumentSubCategory::find($id);
        $document->sub_category = $subcategory;
        $document->category_id = $category_id;
        $document->active = $active;
        $document->save();
        return 'success';
    }

    public function deleteCategory($id = null) {
        $document = DocumentCategory::find($id);
        $document->delete();
        return 'success';
    }

    public function deleteSubCategory($id = null) {
        $document = DocumentSubCategory::find($id);
        $document->delete();
        return 'success';
    }

}
