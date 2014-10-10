<?php

namespace Repository;

use Account;
use Service;
use Oauth;
use Property;
use Setting;
use Region;
use Hash;
use Input;
use Auth;
use DB;
use Rating;

class BackofficeRepository {

        public function checkPermission($email){
        	$account = Account::where('email', '=', $email)->get();
        	return $account[0]->permission;

        }

}
