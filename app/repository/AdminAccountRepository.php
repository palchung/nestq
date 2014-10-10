<?php

namespace Repository;

use Region;
use Input;
use DB;
use Setting;
use Territory;
use Category;
use Transportation;
use Facility;
use Feature;

class AdminAccountRepository {

    public function loadAccountByEmail($email = null) {
        $account = DB::table('account')
            ->where('account.email', '=', $email)
            ->get();
        return $account;
    }

    public function loadPropertyByEmail($email = null) {
        $property = DB::table('account')
            ->join('property', 'property.owner_id', '=', 'account.id')
            ->join('category', 'category.id', '=', 'property.category_id')
            ->join('region', 'region.id', '=', 'property.region_id')
            ->join('territory', 'territory.id', '=', 'region.territory_id')
            ->select([
                'property.created_at as property_created_at',
                'property.responsible_id as property_responsible_id',
                'property.name as property_name',
                'property.soldorrent as property_soldorrent',
                'property.publish as property_publish',
                'category.name as property_category',
                'region.name as property_region',
                'territory.name as property_territory'
            ])
            ->where('account.email', '=', $email)
            ->get();
        return $property;
    }

    public function loadSettingByEmail($email = null) {
        $setting = DB::table('setting')
            ->join('account','account.id','=','setting.account_id')
            ->where('account.email', '=', $email)
            ->get();
        
        return $setting;
    }

}
