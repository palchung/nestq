<?php

Class Conversation extends Eloquent {

        protected $table = 'conversation';
        public static $messageRules = array(
        );

        public function account() {
                return $this->belongsToMany('Account', 'conversation_account');
        }

        public function property() {
                return $this->hasOne('Property');
        }
        
        
        
        
}
