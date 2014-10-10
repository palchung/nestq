<?php

Class Region extends Eloquent {

        protected $table = 'region';

        public function territory() {
                return $this->belongsTo('Territory');
        }

        public function setting() {
                return $this->belongsToMany('Setting', 'setting_region');
        }

        
        
        
        
}
