<?php

Class Pricepage extends Eloquent {

        protected $table = 'pricepage';


        public function payment() {
                 return $this->belongsToMany('Payment', 'payment_pricepage');
        }

}
