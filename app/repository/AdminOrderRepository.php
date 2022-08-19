<?php

namespace Repository;

use DB;


class AdminOrderRepository {

    public function loadPaymentHistoryByEmail($email = null)
    {
        $history = DB::table('payment')
            ->join('account', 'account.id', '=', 'payment.account_id')
            ->join('transaction', 'transaction.payment_id', '=', 'payment.id')
            ->select([
                'payment.id as payment_id',
                'payment.amount as payment_amount',
                'payment.status as payment_status',
                'transaction.updated_at as transaction_updated_at',
                'transaction.transaction_id as transaction_id'
            ])
            ->where('account.email', '=', $email)
            ->where('payment.status', '=', 1)
            ->get();

        if (sizeof($history == 0))
        {
            $history = 'no_record';
        }

        return $history;
    }


    public function loadPaymentHistoryByPaymentId($payment_id = null)
    {

        $history = DB::table('payment')
            ->join('account', 'account.id', '=', 'payment.account_id')
            ->join('transaction', 'transaction.payment_id', '=', 'payment.id')
            ->select([
                'payment.id as payment_id',
                'payment.amount as payment_amount',
                'payment.status as payment_status',
                'transaction.updated_at as transaction_updated_at',
                'transaction.transaction_id as transaction_id'
            ])
            ->where('payment.id', '=', $payment_id)
            ->where('payment.status', '=', 1)
            ->get();

        if (sizeof($history == 0))
        {
            $history = 'no_record';
        }

        return $history;

    }


}
