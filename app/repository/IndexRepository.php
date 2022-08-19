<?php

namespace Repository;

use Account;
use Property;
use Facility;
use Category;
use Region;
use Territory;
use Hash;
use Input;
use Auth;
use DB;

class IndexRepository {

        public static function loadFacilityList($whatToLoad = null) {
                
                $list = Facility::where('active', '=', 1)->get();
                return $list;
        }

        public static function loadCategoryList($whatToLoad = null) {
                
                $list = Category::where('active', '=', 1)->get();
                return $list;
        }

        public static function loadRegionList($whatToLoad = null) {
                
                $list = Region::where('active', '=', 1)->get();
                return $list;
        }

        public static function loadTerritoryList($whatToLoad = null) {
                
                $list = Territory::where('active', '=', 1)->get();
                return $list;
        }

}
