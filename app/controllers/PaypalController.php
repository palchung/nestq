<?php

use Repository\PaypalRepository;
use Repository\PaymentRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

class PaypalController extends BaseController {

        protected $layout = "layout.main";
        protected $paypal;

        public function __construct(PaypalRepository $paypal) {
                $this->beforeFilter('csrf', array('on' => 'post'));
                //$this->beforeFilter('auth', array('only' => array('getDashboard')));
                $this->paypal = $paypal;
        }

        public function getIpn() {
                $listener = new PaypalRepository();
                $listener->use_sandbox = Config::get('nestq.PAYPAL_TEST_MODE');
                $listener->use_ssl = true;
                $errmsg = '';

                if (isset($_GET['token']) && !empty($_GET['token'])) {
                        $payerID = urlencode($_GET['PayerID']);
                        $token = urlencode($_GET['token']);
                        $paymentType = urlencode("Order");

                        $currencyID = Config::get('nestq.PAYMENT_CURRENCY');
                        $paymentInfo = PaymentRepository::loadPaymentDetailByToken($token);
                        $paymentID = $paymentInfo[0]->payment_id;
                        $paymentAmount = $paymentInfo[0]->amount;

                        // Add request-specific fields to the request string.
                        $nvpStr = "&TOKEN=$token&PAYERID=$payerID&PAYMENTREQUEST_0_PAYMENTACTION=$paymentType&PAYMENTREQUEST_0_AMT=$paymentAmount&PAYMENTREQUEST_0_CURRENCYCODE=$currencyID";

                        // Execute the API operation; see the PPHttpPost function above.
                        $httpParsedResponseAr = $listener->PPHttpPost('DoExpressCheckoutPayment', $nvpStr);

                        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                                // Make sure the amount(s) paid match

                                if (urldecode($httpParsedResponseAr['PAYMENTINFO_0_AMT']) != $paymentAmount) {
                                        $errmsg .= "'PAYMENTINFO_0_AMT' does not match: ";
                                        $errmsg .= $httpParsedResponseAr['PAYMENTINFO_0_AMT'] . "\n";
                                }

                                // Make sure the currency code matches

                                if (urldecode($httpParsedResponseAr['PAYMENTINFO_0_CURRENCYCODE']) != $currencyID) {
                                        $errmsg .= "'PAYMENTINFO_0_CURRENCYCODE' does not match: ";
                                        $errmsg .= $httpParsedResponseAr['PAYMENTINFO_0_CURRENCYCODE'] . "\n";
                                }

                                // TODO: Check for duplicate txn_id
                                // Ensure the transaction is not a duplicate.

                                $transactionID = urldecode($httpParsedResponseAr['PAYMENTINFO_0_TRANSACTIONID']);

                                $exists = PaymentRepository::checkRepeatPayment($transactionID);

                                if ($exists == 'not_ok') {
                                        $errmsg .= "'txn_id' has already been processed: " . $httpParsedResponseAr['PAYMENTINFO_0_TRANSACTIONID'] . "\n";
                                }

                                if (!empty($errmsg)) {
                                        // manually investigate errors from the fraud checking
                                        $body = "IPN failed fraud checks: \n$errmsg\n\n";
                                        //$body .= $listener -> getTextReport();
                                        mail(Config::get('nestq.ADMIN_EMAIL'), 'IPN Fraud Warning: Payment No. ' . print_r($paymentInfo[0], true), $body);
                                } else {
                                        // payment success
                                        session_start();
                                        $_SESSION['payment_id'] = $paymentID;
                                        $_SESSION['transaction_id'] = $transactionID;
                                        $_SESSION['channel'] = 'Pay Pal';
                                        return Redirect::to('payment/success');
                                }
                        } else {
                                //mail(Config::get('nestq.ADMIN_EMAIL'), 'DoExpressCheckoutPayment failed: Order No. ' . print_r($paymentInfo[0], true), print_r($httpParsedResponseAr, true));
                                return Redirect::to('payment/fail');
                        }
                }
        }

}
