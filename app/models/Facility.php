<?php

Class Facility extends Eloquent {

        protected $table = 'facility';

        public function property() {
                 return $this->belongsToMany('Property', 'property_facility');
        }

        
        
        
        
}
