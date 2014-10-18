<?php

Class Service extends Eloquent {

    protected $table = 'service';

//    public static function checkmessengerPaidStatus() {
//        $status = DB::table('service')
//            ->where('account_id', '=', Auth::user()->id)
//            ->where('item_id', '=', Config::get('nestq.MESSENGER_ID'))
//            ->where('period', '>', new DateTime('today'))
//            ->get();
//
//        if (sizeof($status) > 0) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public static function checkServicePayment($service_id = null) {
        $check = DB::table('service')
            ->where('account_id', '=', Auth::user()->id)
            ->where('item_id', '=', $service_id)
            ->where('period', '>', new DateTime('today'))
            ->get();
        if (sizeof($check) == 0) {
            return 'not_paid';
        } else {
            return 'paid';
        }
    }

}
