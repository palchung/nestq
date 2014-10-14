<?php

namespace Repository;


use Config;
use Pricepage;
use Payment;
use Transaction;
use PaymentPricepage;
use Auth;
use DB;
use Service;
use Carbon\Carbon;
use Pricing;
use Image;
use Input;


class PaymentRepository {

    public function __construct()
    {

        $this->mHandlingCharge = 0;
    }

    public function loadPricePageItems()
    {
        $items = DB::table('pricepage')
            ->where('active', '=', 1)
            ->get();

        return $items;
    }

    public function loadSchemes()
    {
        $schemes = DB::table('pricing')
            ->where('active', '=', 1)
            ->get();

        return $schemes;
    }


    public function loadSchemesDetailByPaymentId($payment_id = null)
    {
        $payment = Payment::find($payment_id);

        return $payment;
    }


    public function loadPackage($packageNo)
    {

        $packages = DB::table('pricepage')
            ->where('package', '=', $packageNo)
            ->where('active', '=', 1)
            ->get();

        $packagePrice = 0;

        for ($i = 0; $i < sizeof($packages); $i++)
        {
            $packagePrice += $packages[$i]->price;
        }

        //$packagePrice = $packagePrice * Config::get('nestq.PACKAGE_MUILT');

        $data = [
            'package'      => $packages,
            'packagePrice' => $packagePrice,
            'packageNo'    => $packageNo
        ];

        return $data;
    }

    /*    public function calPackagePrice($packageNo) {

      $packages = DB::table('pricepage')
      ->where('package', '=', $packageNo)
      ->where('active', '=', 1)
      ->get();

      $packagePrice = 0;
      for ($i = 0; $i < sizeof($packages); $i++) {
      $packagePrice += $packages[$i]->price;
      }
      $packagePrice = $packagePrice * Config::get('nestq.PACKAGE_MUILT');

      return $packagePrice;
  } */


    public static function loadPaymentHistoryByAccountId($account_id)
    {

        $payment = DB::table('payment')
            ->join('pricing', 'payment.pricing_id', '=', 'pricing.id')
            ->where('payment.account_id', '=', $account_id)
            ->where('payment.status', '=', 1)
            ->orderBy('payment.updated_at', 'DESC')
            ->get();

        return $payment;

    }


    public function checkPurchasePermission($account_id)
    {

        $now = Carbon::now();
//        $current = date('Y-m-d H:i:s', strtotime($now) * 86400);
        $greyPeriod = Config::get('nestq.PERMISSION_PERIOD');

        $lastPayment = Payment::orderBy('id', 'DESC')
            ->where('account_id', '=', $account_id)
            ->where('status', '=', 1)
            ->first();

        if ($lastPayment)
        {
            $dueDate = date('Y-m-d H:i:s', strtotime($lastPayment->due_date) - $greyPeriod * 86400);
            if ($now >= $dueDate)
            {
                return 'ok';
            } else
            {
                return 'not_ok';
            }
        } else
        {
            return 'ok';
        }
    }


    public function createPayment($item_id)
    {


        $price = Pricepage::find($item_id)->price;

        $payment = new Payment;
        $payment->account_id = Auth::user()->id;
        $payment->status = 0; // 0 standfor not pay yet.
        $payment->amount = $price;

        $payment->save();

        $item = new PaymentPricepage;
        $item->payment_id = $payment->id;
        $item->pricepage_id = $item_id;
        $item->save();

        return $payment;
    }

    public function createPackagePayment($packageNo = null, $multi = null, $period = null, $pricing_id = null)
    {

        $detail = PaymentRepository::loadPackage($packageNo);
        $paidAmount = $detail['packagePrice'] * $multi;

        $payment = new Payment;
        $payment->account_id = Auth::user()->id;
        $payment->status = 0; // 0 standfor not pay yet.
        $payment->amount = $paidAmount;
        $payment->pricing_id = $pricing_id;
        $payment->period = $period;
        $payment->save();

        for ($i = 0; $i < sizeof($detail['package']); $i++)
        {
            $item = new PaymentPricepage;
            $item->payment_id = $payment->id;
            $item->pricepage_id = $detail['package'][$i]->id;
            $item->save();
        }

        return $payment;
    }

    public static function loadPaymentDetailById($payment_id)
    {
        $payment = DB::table('payment')
            ->where('payment.id', '=', $payment_id)
            ->get();

        return $payment[0];
    }

    public static function loadPaymentDetailByToken($token)
    {
        $payment = DB::table('payment')
            ->join('transaction', 'payment.id', '=', 'transaction.payment_id')
            ->where('token', '=', $token)
            ->groupBy('payment.id')
            ->get();

        return $payment;
    }

    public static function checkRepeatPayment($transaction_id)
    {
        $exist = DB::table('transaction')
            ->where('transaction_id', '=', $transaction_id)
            ->get();
        if (sizeof($exist) != 0)
        {
            return 'not_ok';
        } else
        {
            return 'ok';
        }
    }

    public static function saveTransactionId($payment_id, $transaction_id)
    {

        $transaction = DB::table('transaction')
            ->where('payment_id', $payment_id)
            ->update(array('transaction_id' => $transaction_id));

        $payment = DB::table('payment')
            ->where('id', $payment_id)
            ->update(array('status' => 1)); // 1 stand for paid

        return;
    }

    public static function savePaymentToken($payment_id, $token)
    {
        $transaction = new Transaction;
        $transaction->payment_id = $payment_id;
        $transaction->token = $token;
        $transaction->save();

        return;
    }

    public function saveChannel($payment_id, $channel)
    {

        $save = DB::table('transaction')
            ->where('payment_id', $payment_id)
            ->update(array('channel' => $channel));

        return;
    }


    public function updateServiceDueDate($payment_id)
    {

        $now = Carbon::now();
        $lastPayment = Payment::orderBy('id', 'DESC')
            ->where('account_id', '=', Auth::user()->id)
            ->first();
        if ($lastPayment)
        {

            $last_time = date('Y-m-d H:i:s', strtotime($lastPayment->due_date));
            if ($last_time <= $now)
            {
                $time = $now;
            } else
            {
                $time = $lastPayment->due_date;
            }

        } else
        {
            $time = $now;
        }

        $payment = Payment::find($payment_id);
        $payment->due_date = date('Y-m-d H:i:s', strtotime($time) + $payment->period * 86400);
        $payment->save();

        return;

    }


    public function processPayment($payment_id = null, $channel = null, $transferNo = null)
    {

        $payment = PaymentRepository::loadPaymentDetailById($payment_id);

        PaymentRepository::saveChannel($payment_id, $channel);

        if ($channel == 'bank_in')
        {

            session_start();
            $_SESSION['payment_id'] = $payment_id;
            $_SESSION['transaction_id'] = $transferNo;
            $_SESSION['channel'] = '銀行過賬';

            $receipt = Input::file('receipt');
            $filename = sha1(time() . Auth::user()->email) . '.' . $receipt->getClientOriginalExtension();
            $path = public_path('receipt/' . $filename);

            Image::make($receipt->getRealPath())->resize(300, 300)->save($path);

            $upload_receipt = Payment::find($payment_id);
            $upload_receipt->receipt = $filename;
            $upload_receipt->save();


            return 'ok';


        } elseif ($channel == 'paypal')
        {

            $listener = new PaypalRepository();
            $listener->use_sandbox = Config::get('nestq.PAYPAL_TEST_MODE');
            $listener->use_ssl = true;

            // Add request-specific fields to the request string.
            // This will contain the PayPal link
            $nvpStr = '&L_PAYMENTREQUEST_0_ITEMCATEGORY0=' . 'Digital' .
                '&L_PAYMENTREQUEST_0_NAME0=NesQPayment' . urlencode('#') . $payment->id .
                '&L_PAYMENTREQUEST_0_QTY0=' . '1' .
                '&L_PAYMENTREQUEST_0_AMT0=' . $payment->amount .
                //'&PAYMENTREQUEST_0_SHIPPINGAMT=' . $this->mShippingCost .
                '&PAYMENTREQUEST_0_ITEMAMT=' . $payment->amount .
                //'&PAYMENTREQUEST_0_HANDLINGAMT=' . $this->mHandlingCharge .
                '&PAYMENTREQUEST_0_AMT=' . $payment->amount .
                '&PAYMENTREQUEST_0_CURRENCYCODE=' . Config::get('nestq.PAYMENT_CURRENCY') .
                '&ReturnUrl=' . Config::get('nestq.PAYPAL_RETURNURL') .
                '&PAYMENTREQUEST_0_SHIPTOSTREET=' . '' .
                //'&PAYMENTREQUEST_0_SHIPTOSTREET2=' . $this->mCustomerData['address_2'] .
                '&PAYMENTREQUEST_0_SHIPTOCITY=' . 'Hong Kong' .
                '&email=' . Auth::user()->email .
                '&PAYMENTREQUEST_0_SHIPTONAME=' . Auth::user()->firstname . Auth::user()->lastname .
                '&LOCALECODE=' . 'HK' .
                '&PAYMENTREQUEST_0_SHIPTOZIP=' . '852' .
                '&PAYMENTREQUEST_0_PAYMENTACTION=' . 'order' .
                '&CANCELURL=' . Config::get('nestq.PAYPAL_CANCELURL');

            // Execute the API operation; see the PPHttpPost function above.
            $httpParsedResponseAr = $listener->PPHttpPost('SetExpressCheckout', $nvpStr);

            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
            {
                // Redirect to paypal.com.
                $token = urldecode($httpParsedResponseAr["TOKEN"]);

                $payment = PaymentRepository::savePaymentToken($payment_id, $token);

                $payPalURL = "https://www.paypal.com/webscr&cmd=_express-checkout&token=$token";
                if ($listener->use_sandbox)
                {
                    $payPalURL = "https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=$token";
                }
                header("Location: $payPalURL");
                exit();
            } else
            {
                mail(Config::get('nestq.ADMIN_EMAIL'), 'SetExpressCheckout failed: ', print_r($httpParsedResponseAr, true));

                return 'fail';
            }
            exit();

        }

    }

    public function loadPaidSerivcesById($payment_id)
    {
        $items = DB::table('payment_pricepage')
            ->join('payment', 'payment_pricepage.payment_id', '=', 'payment.id')
            ->select([
                'payment.account_id as account_id',
                'payment_pricepage.pricepage_id as pricepage_id',
                'payment.period as period'
            ])
            ->where('payment_id', '=', $payment_id)
            ->get();

        return $items;
    }


    public function loadServiceByAccountId($account_id)
    {

        $service = DB::table('service')
            ->where('account_id', '=', $account_id)
            ->get();

        return $service;

    }


    public function activateService($payment_id)
    {

        // active push
        $items = $this->loadPaidSerivcesById($payment_id);

        foreach ($items as $item)
        {
            $this->extendServices($item->account_id, $item->pricepage_id, $item->period);
        }

        return 'success';
    }

    public function loadAccountByPaymentId($payment_id)
    {

        $account_id = Payment::find($payment_id)->account_id;

        return $account_id;


    }

    public static function extendServices($account_id = null, $item_id = null, $period = null)
    {

        $service = DB::table('service')
            ->where('account_id', '=', $account_id)
            ->where('item_id', '=', $item_id)
            ->get();

        $now = Carbon::now();
        if (sizeof($service) == 0) // not purchase before
        {
            $service = New Service;
            $service->account_id = $account_id;
            $service->item_id = $item_id;
            $service->period = date('Y-m-d H:i:s', strtotime($now) + $period * 86400);
            $service->save();
        } else // have purchased
        {

            if (date('Y-m-d H:i:s', strtotime($service[0]->period)) <= $now)
            {
                $time = $now;
            } else
            {
                $time = $service[0]->period;
            }

            $newPeriod = date('Y-m-d H:i:s', strtotime($time) + $period * 86400);
            Service::where('account_id', '=', $account_id)
                ->where('item_id', '=', $item_id)
                ->update(array('period' => $newPeriod));

        }

        return;
    }

    public function loadPackageByID($package_id)
    {
        $package = Pricing::find($package_id);

        return $package;
    }


    /*
      public function checkActivePushByPaymentId($payment_id) {

      $activepush_id = Config::get('nestq.ACTIVE_PUSH_ID');

      $check = DB::table('payment_pricepage')
      ->where('payment_id', '=', $payment_id)
      ->where('pricepage_id', '=', $activepush_id)
      ->get();
      if (sizeof($check) != 0) {
      return 'paid';
      } else {
      return 'not_paid';
      }
      }

      public static function checkActivePushByAccount($property_id) {

      $checkRepeat = DB::table('service')
      ->where('property_id', '=', $property_id)
      ->where('activepush', '=', 1)
      ->get();
      if (sizeof($checkRepeat) != 0){
      return 'activrated';
      } else {
      $check = DB::table('payment')
      ->join('payment_pricepage', 'payment_pricepage.payment_id', '=', 'payment.id')
      ->where('payment.account_id', '=', Auth::user()->id)
      ->where('payment_pricepage.pricepage_id', '=', Config::get('nestq.ACTIVE_PUSH_ID'))
      ->get();

      if (sizeof($check) != 0) {
      return 'ok';
      } else {
      return 'not_ok';
      }
      }
      }
     */
}
