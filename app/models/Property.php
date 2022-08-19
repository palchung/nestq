<?php

Class Property extends Eloquent {

    protected $table = 'property';
    public static $PropertyRules = array(
        'name'          => 'required|alpha|min:2',
        'price'         => 'required|integer|digits_between:2,4',
        'rentprice'     => 'required|integer|digits_between:3,6',
        'address'       => 'required|alpha|min:2',
//        'block'         => '|integer|alpha|min:1',
//        'floor'         => '|integer|alpha|min:1',
//        'room'          => '|integer|alpha|min:1',
        'noslivingroom' => 'required|integer|digits_between:1,2',
        'nosroom'       => 'required|integer|digits_between:1,2',
        'structuresize' => 'required|integer|digits_between:3,5',
        'actualsize'    => 'required|integer|digits_between:3,5',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:5'

    );
    public static $RequisitionRules = array(
        'template' => 'required|alpha|min:2',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:5'
    );

    public static $photoRules = array(
        'file' => 'image|max:3000',
    );

    public function facility()
    {
        return $this->belongsToMany('Facility', 'property_facility');
    }


    public function transportation()
    {
        return $this->belongsToMany('Transportation', 'property_transportation');
    }

    public function feature()
    {
        return $this->belongsToMany('Feature', 'property_feature');
    }


    public function category()
    {
        return $this->hasOne('Category');
    }

    public function region()
    {
        return $this->hasOne('Region');
    }

}
