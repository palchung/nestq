<?php

Class Payment extends Eloquent {

        protected $table = 'payment';


        public function pricepage() {
                return $this->belongsToMany('Pricepage', 'payment_pricepage');
        }

        public function pricing () {
            return $this->hasMany('Pricing');
        }



}
