<?php

Class Setting extends Eloquent {

    protected $table = 'setting';

    public function region()
    {
        return $this->belongsToMany('Region', 'setting_region');
    }

    public function category()
    {
        return $this->belongsToMany('Category', 'setting_category');
    }

    public function account()
    {
        return $this->belongsTo('Account');
    }

}
