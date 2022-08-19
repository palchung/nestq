<?php

namespace Repository;

use Region;
use Input;
use DB;
use Territory;
use Category;
use Transportation;
use Facility;
use Feature;
use Pricepage;
use Pricing;

class AdminPricingRepository {

    public function loadProducts() {
        $items = Pricepage::all();
        return $items;
    }

    public function loadSchemes() {
        $schemes = Pricing::all();
        return $schemes;
    }

    public function editPricepage($id = null, $item = null, $price = null, $package = null, $active = null) {
        $pricepage = Pricepage::find($id);
        $pricepage->item = $item;
        $pricepage->price = $price;
        $pricepage->package = $package;
        $pricepage->active = $active;
        $pricepage->save();
        return 'success';
    }

    public function deletePricepageItem($id = null) {
        $pricepage = Pricepage::find($id);
        $pricepage->delete();
        return 'success';
    }

    public function createPricepageItem($item = null, $price = null, $package = null) {
        $pricepage = new Pricepage;
        $pricepage->item = $item;
        $pricepage->price = $price;
        $pricepage->package = $package;
        $pricepage->active = 1;
        $pricepage->save();
        return 'success';
    }

    public function editScheme($id = null, $scheme = null, $multi = null, $active = null, $period = null) {
        $pricing = Pricing::find($id);
        $pricing->scheme = $scheme;
        $pricing->multi = $multi;
        $pricing->active = $active;
        $pricing->period = $period;
        $pricing->save();
        return 'success';
    }

    public function deleteScheme($id = null) {
        $pricing = Pricing::find($id);
        $pricing->delete();
        return 'success';
    }

    public function createScheme($scheme = null, $multi = null, $period = null) {
        $pricing = new Pricing;
        $pricing->scheme = $scheme;
        $pricing->multi = $multi;
        $pricing->period = $period;
        $pricing->active = 1;
        $pricing->save();
        return 'success';
    }

}
