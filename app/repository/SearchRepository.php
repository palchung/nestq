<?php

namespace Repository;

use Account;
use Session;
use Property;
use Facility;
use Category;
use Region;
use Search;
use Hash;
use Input;
use Auth;
use DB;
use Config;
use StdClass;

class SearchRepository {

    public function __construct()
    {

        $this->region = Input::get('region');
        $this->region = (isset($this->region)) ? $this->region : null;
        Session::put('region', $this->region);

        $this->category = Input::get('category');
        $this->category = (isset($this->category)) ? $this->category : null;
        Session::put('category', $this->category);

        $this->facility = Input::get('facility');
        $this->facility = (isset($this->facility)) ? $this->facility : null;
        Session::put('facility', $this->facility);

        $this->rent = Input::get('rent');
        Session::put('rent', $this->rent);
        $this->sale = Input::get('sale');
        Session::put('sale', $this->sale);

        $this->user = Input::get('user');
        Session::put('user', $this->user);
        $this->agent = Input::get('agent');
        Session::put('agent', $this->agent);

        $this->price = Input::get('price');
        Session::put('price', $this->price);
        $this->priceRange = Input::get('priceRange');
        $this->priceRange = ( ! empty($this->priceRange) || trim($this->priceRange) != '') ? $this->priceRange : Config::get('nestq.SEARCH_PRICE_RANGE');
        Session::put('priceRange', $this->priceRange);

        $this->rentprice = Input::get('rentprice');
        Session::put('rentprice', $this->rentprice);
        $this->rentpriceRange = Input::get('rentpriceRange');
        $this->rentpriceRange = ( ! empty($this->rentpriceRange) || trim($this->rentpriceRange) != '') ? $this->rentpriceRange : Config::get('nestq.SEARCH_RENT_PRICE_RANGE');
        Session::put('rentpriceRange', $this->rentpriceRange);

        $this->actualsize = Input::get('actualsize');
        Session::put('actualsize', $this->actualsize);
        $this->sizeRange = Input::get('sizeRange');
        $this->sizeRange = ( ! empty($this->sizeRange) || trim($this->sizeRange) != '') ? $this->sizeRange : Config::get('nestq.SEARCH_SIZE_RANGE');
        Session::put('sizeRange', $this->sizeRange);

        $this->period = Input::get('period');
        $this->nosroom = Input::get('nosroom');
        $this->noslivingroom = Input::get('noslivingroom');
    }

    public function searchProperty()
    {

        $seeking_rental = false;

        $query = DB::table('property');

        if ( ! ( ! empty($this->user) && ! empty($this->agent)))
        {
            if ( ! empty($this->user) || ! empty($this->agent))
            {
                $query->join('account', 'property.responsible_id', '=', 'account.id');
            }

            if ( ! empty($this->user))
            {
                $query->where('account.identity', '=', 0); //property ppst from user
            } elseif ( ! empty($this->agent))
            {
                $query->where('account.identity', '=', 1); //property post from agent
            }
        }
        if ( ! is_null($this->region))
        {
            $query->join('region', 'property.region_id', '=', 'region.id');
            $query->whereIn('region.id', $this->region);
            //$query->where('region.active','=',1);
        }
        if ( ! is_null($this->category))
        {
            $query->join('category', 'property.category_id', '=', 'category.id');
            $query->whereIn('category.id', $this->category);
            //$query->where('category.active','=',1);
        }
        if ( ! is_null($this->facility))
        {
            $query->join('property_facility', 'property.id', '=', 'property_facility.property_id');
            $query->join('facility', 'property_facility.facility_id', '=', 'facility.id');
            $query->whereIn('property_facility.facility_id', $this->facility);
            //$query->where('facility.active','=',1);
        }
        if ( ! ( ! empty($this->rent) && ! empty($this->sale)))
        {
            if ( ! empty($this->rent))
            {
                $y = Array(0, 2); // 0 stand for rental
                $seeking_rental = true;
            } elseif ( ! empty($this->sale))
            {
                $y = Array(1, 2);
            } else
            {
                $y = Array(0, 1, 2);
                $seeking_rental = true;
            }
            $query->whereIn('property.soldorrent', $y);
        }

        if ( ! empty($this->price))
        {
            $priceUpper = $this->price + $this->priceRange;
            $priceLower = $this->price - $this->priceRange;
            $query->where('property.price', '<=', $priceUpper);
            $query->where('property.price', '>=', $priceLower);
        }

        if ($seeking_rental && ! empty($this->rentprice))
        {
            $rentpriceUpper = $this->rentprice + $this->rentpriceRange;
            $rentpriceLower = $this->rentprice - $this->rentpriceRange;
            $query->where('property.rentprice', '<=', $rentpriceUpper);
            $query->where('property.rentprice', '>=', $rentpriceLower);
        }
        if ( ! empty($this->actualsize))
        {
            $areaUpper = $this->actualsize + $this->sizeRange;
            $areaLower = $this->actualsize - $this->sizeRange;
            $query->where('property.actualsize', '<=', $areaUpper);
            $query->where('property.actualsize', '>=', $areaLower);
        }

        if ($this->period != 'all')
        {
            $x = date('Y-m-d') - $this->period;
            $query->where('property.created_at', '>=', $x);
        }
        if ($this->nosroom != 'all')
        {
            if ($this->nosroom == '4')
            {
                $query->where('property.nosroom', '>=', $this->nosroom);
            } else
            {
                $query->where('property.nosroom', '=', $this->nosroom);
            }
        }
        if ($this->noslivingroom != 'all')
        {
            if ($this->noslivingroom == 4)
            {
                $query->where('property.noslivingroom', '>=', $this->noslivingroom);
            } else
            {
                $query->where('property.noslivingroom', '=', $this->noslivingroom);
            }
        }
        $query->select([
            'property.id as property_id',
            'property.name as property_name',
            'property.created_at as property_created_at',
            'property.updated_at as property_updated_at',
            'property.responsible_id as property_responsible_id',
            'property.structuresize as property_structuresize',
            'property.actualsize as property_actualsize',
            'property.price as property_price',
            'property.rentprice as property_rentprice',
            'property.photo as property_photo',
            'property.geolocation as property_geolocation',
            'property.nosroom as property_nosroom',
            'property.noslivingroom as property_noslivingroom',
            'property.address as property_address',
            'property.floor as property_floor',
            'property.room as property_room',
            'property.block as property_block'
        ]);
        $query->where('property.publish', '=', 1);

        $query->groupBy('property.id');
        $query->orderBy('property.updated_at', 'desc');

        return $query;
    }

}
