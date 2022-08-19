<?php

namespace Repository;

use Account;
use Config;
use Pricepage;
use Payment;
use Transaction;
use PaymentPricepage;
use Property;
use Facility;
use Category;
use Region;
use Territory;
use Hash;
use Input;
use Auth;
use DB;
use Service;
use DateTime;

class ServiceRepository {

//    public function __construct(PropertyRepository $property) {
//        
//        $this->posting_property_service = Config::get('nestq.POSTING_PROPERTY_ID');
//        $this->active_push_service = Config::get('nestq.ACTIVE_PUSH_ID');
//        $this->active_maiil_service = Config::get('nestq.ACTIVE_MAIL_ID');
//        $this->messenger_service = Config::get('nestq.MESSENGER_ID');
//        $this->requisition_service = Config::get('nestq.REQUISITION_ID');
//        
//    }

    public static function checkServicePayment($service_id = null) {
        $check = DB::table('service')
            ->where('account_id','=',Auth::user()->id)
            ->where('item_id','=', $service_id)
            ->where('period', '>', new DateTime('today'))
            ->get();
        if(sizeof($check) == 0){
            return 'not_paid';
        }else{
            return 'paid';
        }
    }

}
