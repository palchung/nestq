<?php

use Repository\AdminOrderRepository;

class AdminOrderController extends BaseController {

    protected $layout = "layout.backoffice";
    protected $adminOrder;

    public function __construct(AdminOrderRepository $adminOrder)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('on' => array('post', 'get')));
        $this->adminOrder = $adminOrder;
    }

    public function getIndex()
    {

        $this->layout->content = View::make('backoffice.order')
            ->with('toShow', 'index');
    }

    public function postAccount()
    {

        $email = Input::get('email');

        if ($email != '')
        {

            $histories = $this->adminOrder->loadPaymentHistoryByEmail($email);

            $this->layout->content = View::make('backoffice.order')
                ->with('histories', $histories)
                ->with('toShow', 'account_history');

        } else
        {
            $this->layout->content = View::make('backoffice.order')
                ->with('toShow', 'index');

        }
    }

    public function postPayment()
    {

        $payment_id = Input::get('paymentId');

        if ($payment_id != ''){

            $histories = $this->adminOrder->loadPaymentHistoryByPaymentId($payment_id);

            $this->layout->content = View::make('backoffice.order')
                ->with('histories', $histories)
                ->with('toShow', 'account_history');

        }else{
            $this->layout->content = View::make('backoffice.order')
                ->with('toShow', 'index');
        }


    }


}
