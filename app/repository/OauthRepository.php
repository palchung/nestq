<?php

namespace Repository;

use Account;
use Property;
use Facility;
use Category;
use Region;
use Territory;
use Hash;
use Input;
use Auth;
use DB;

class OauthRepository {

        public function saveOrLoginAccount($data = null) {

                $oauth = [];
                $oauth['email'] = $data['email'];
                $oauth['firstname'] = $data['firstname'];
                $oauth['lastname'] = $data['lastname'];
                $oauth['provider'] = $data['provider'];

                $account = OauthRepository::checkAccountExistence($oauth['email']);
                if ($account != 'new_account') {

                        Auth::loginUsingId($account);
                        return;
                } else {
                        $create_id = AccountRepository::createAccount($identity = 0, $oauth);
                        
                        Auth::loginUsingId($create_id);
                        return;
                }
        }

        public static function checkAccountExistence($email = null) {
                $account = Account::where('email', '=', $email)->first();
                if (empty($account)) {
                        return 'new_account';
                } else {
                        return $account->id;
                }
        }

}
