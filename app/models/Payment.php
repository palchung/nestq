<?php

Class Payment extends Eloquent {

    protected $table = 'payment';


    public static $paymentRules = array(
        );


    public function pricepage() {
        return $this->belongsToMany('Pricepage', 'payment_pricepage');
    }

    public function pricing () {
        return $this->hasMany('Pricing');
    }



}
