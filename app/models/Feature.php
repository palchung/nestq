<?php

Class Feature extends Eloquent {

        protected $table = 'feature';

        public function property() {
                 return $this->belongsToMany('Property', 'property_feature');
        }

        
        
        
        
}
