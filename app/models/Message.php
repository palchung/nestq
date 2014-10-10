<?php

Class Message extends Eloquent {

        protected $table = 'message';

        
        
        public function conversation() {
                return $this->hasOne('Conversation');
        }
        
        
        
        
}
