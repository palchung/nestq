<?php

namespace Repository;

use Account;
use Property;
use Facility;
use Category;
use Region;
use Hash;
use Input;
use Auth;
use DB;
use Config;

class InquiryRepository {

	public function loadDocumentActiveCategory($whatToLoad = null) {
		if ($whatToLoad == 'category') {
			$list = DB::table('documentcategory')->where('active', '=', 1)->orderBy('category', 'asc')->get();
		} elseif ($whatToLoad == 'subcategory') {
			$list = DB::table('documentsubcategory')->where('active', '=', 1)->orderBy('sub_category', 'asc')->get();
		}
		return $list;
	}

	public function loadDocumentActiveSubCategoryById($categoryId = null){

		$list = DB::table('documentsubcategory')
		->where('active', '=', 1)
		->where('category_id','=',$categoryId)
		->orderBy('sub_category', 'asc')
		->get();
		return $list;
	}




	public function loadDocument($subcategoryId = null){

		$documents = DB::table('documentation')
		->join('documentsubcategory','documentation.sub_category_id','=','documentsubcategory.id')
		->where('documentation.sub_category_id','=', $subcategoryId)
		->where('documentsubcategory.active', '=', 1)
		->get();
		return $documents;
	}


}
