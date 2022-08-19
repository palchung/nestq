<?php

Class Transportation extends Eloquent {

        protected $table = 'transportation';

        public function property() {
                 return $this->belongsToMany('Property', 'property_transportation');
        }

        
        
        
        
}
