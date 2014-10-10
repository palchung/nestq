<?php

Class Property extends Eloquent {

        protected $table = 'property';
        public static $propertyRules = array(
            
        );
        public static $photoRules = array(
            'file' => 'image|max:3000',
        );

        public function facility() {
                return $this->belongsToMany('Facility', 'property_facility');
        }


        public function transportation() {
                return $this->belongsToMany('Transportation', 'property_transportation');
        }

        public function feature() {
                return $this->belongsToMany('Feature', 'property_feature');
        }


        public function category() {
                return $this->hasOne('Category');
        }

        public function region() {
                return $this->hasOne('Region');
        }

}
