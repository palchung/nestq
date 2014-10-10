<?php

Class Setting extends Eloquent {

        protected $table = 'setting';

        public function region() {
                return $this->belongsToMany('Region', 'setting_region');
        }

        public function account() {
                return $this->belongsTo('Account');
        }

}
