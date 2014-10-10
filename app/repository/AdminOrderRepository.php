<?php

namespace Repository;

use Region;
use Input;
use DB;
use Territory;
use Category;
use Transportation;
use Facility;
use Feature;

class AdminOrderRepository {

    public function loadPaymentHistoryByEmail($email = null) {
        $history = DB::table('payment')
            ->join('account', 'account.id', '=', 'payment.account_id')
            ->join('transaction','transaction.payment_id','=','payment.id')
            ->select([
                'payment.id as payment_id',
                'payment.amount as payment_amount',
                'payment.status as payment_status',
                'transaction.updated_at as transaction_updated_at',
                'transaction.transaction_id as transaction_id'
                
            ])
            ->where('account.email', '=', $email)
            ->get();
        
        return $history;
    }

}
