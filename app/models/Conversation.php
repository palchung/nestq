<?php

Class Conversation extends Eloquent {

        protected $table = 'conversation';
        public static $messageRules = array(
            // 'message'           => 'required|alpha|min:2',
            //spam prevention
            'my_name'   => 'honeypot',
            'my_time'   => 'required|honeytime:5',
        );

        public function account() {
                return $this->belongsToMany('Account', 'conversation_account');
        }

        public function property() {
                return $this->hasOne('Property');
        }




}
