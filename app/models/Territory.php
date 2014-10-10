<?php

Class Territory extends Eloquent {

        protected $table = 'territory';
        
                public function region() {
                return $this->hasMany('Region');
        }

}
