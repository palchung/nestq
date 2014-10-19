<?php

use Repository\PaymentRepository;

class PaymentController extends BaseController {

    protected $layout = "layout.main";
    protected $payment;

    public function __construct(PaymentRepository $payment) {
        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getPricepage', 'postPurchaseitem')));
        $this->payment = $payment;
    }

    public function getSuccess() {

        session_start();

        $this->payment->saveTransactionId($_SESSION['payment_id'], $_SESSION['transaction_id'], $_SESSION['channel']);
        $this->payment->updateServiceDueDate($_SESSION['payment_id']);
        $activate_service = $this->payment->activateService($_SESSION['payment_id']);

        // $payment = $this->payment->loadPaymentDetailById($_SESSION['payment_id']);
        $payment = $this->payment->loadSchemesDetailByPaymentId($_SESSION['payment_id']);


        $channel = $_SESSION['channel'];

        if ($activate_service == 'success') {

            if (Auth::check()){
                Auth::logout();
            }
            $account_id = $this->payment->loadAccountByPaymentId($_SESSION['payment_id']);
            $account = Account::find($account_id);
            Auth::login($account);

            $service = $this->payment->loadServiceByAccountId($account_id);


            $this->layout->content = View::make('payment.success')
            ->with('transaction', $_SESSION['transaction_id'])
            ->with('payment', $payment)
            ->with('channel', $channel)
            ->with('services', $service)
            ->with('account', $account);
        } else {
            $this->layout->content = View::make('payment.fail');
        }


    }

    public function getFail() {
        $this->layout->content = View::make('payment.fail');
    }

    public function getPricepage() {

        //load package
        $packageNo = 1;
        $packages = $this->payment->loadPackage($packageNo);
        $schemes = $this->payment->loadSchemes();

        // load individual item
        $items = $this->payment->loadPricePageItems();

        $this->layout->content = View::make('payment.pricepage')
        ->with('items', $items)
        ->with('schemes', $schemes)
        ->with('packages', $packages);
    }

    public function postPurchaseitem() {

        $checkPurchasePermission = $this->payment->checkPurchasePermission(Auth::user()->id);

        if ($checkPurchasePermission == 'ok') {
            $item_id = Input::get('itemId');
            $payment = $this->payment->createPayment();
            $this->layout->content = View::make('payment.checkout')
            ->with(compact('payment'));
        } else {
            return Redirect::to('account/dashboard/permission_deny');
        }
    }

    public function postPurchasepackage() {

        $checkPurchasePermission = $this->payment->checkPurchasePermission(Auth::user()->id);

        if ($checkPurchasePermission == 'ok') {

            $packageNo = Input::get('packageNo');
            $multi = Input::get('multi');
            $pricing_id = Input::get('pricingId');
            $period = Input::get('period');
            $package = $this->payment->loadPackageById($packageNo);

            $payment = $this->payment->createPackagePayment($packageNo, $multi, $period, $pricing_id);

            $this->layout->content = View::make('payment.checkout')
            ->with(compact('payment'))
            ->with('package',$package);
        } else {
            return Redirect::to('account/dashboard/permission_deny');
        }

    }

    public function postCheckout() {

        $payment_id = Input::get('paymentId');
        $channel = Input::get('channel');

        if ($channel == 'bank_in') {

            $validator = Validator::make(Input::all(), Payment::$paymentRules);
            if ($validator->fails())
            {
                return Redirect::to('payment/purchasepackage')->with('flash_message', 'The following errors occurred');
            }

            $transferNo = Input::get('transferNo');

        } else {
            $transferNo = null ;
            $receipt = null;
        }

        $process = $this->payment->processPayment($payment_id, $channel, $transferNo);

        if ($process == 'ok') {
            return Redirect::to('payment/success');
        } elseif ($process == 'fail') {
            $this->layout->content = View::make('payment.fail');
        }
        exit();


    }














}
