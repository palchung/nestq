<?php

use Repository\AdminAccountRepository;

class AdminAccountController extends BaseController {

    protected $layout = "layout.backoffice";
    protected $adminAccount;

    public function __construct(AdminAccountRepository $adminAccount) {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('on' => array('post', 'get')));
        $this->adminAccount = $adminAccount;
    }

    public function getIndex() {
        $this->layout->content = View::make('backoffice.account')
            ->with('accounts', '');
    }

    public function postSearch() {
        $email = Input::get('email');

        if ($email != '') {

            $accounts = $this->adminAccount->loadAccountByEmail($email);
            $properties = $this->adminAccount->loadPropertyByEmail($email);
            $setting = $this->adminAccount->loadSettingByEmail($email);
            if (sizeof($accounts) != 0) {
                $this->layout->content = View::make('backoffice.account')
                    ->with('accounts', $accounts)
                    ->with('properties', $properties)
                    ->with('settings', $setting);
            } else {
                $this->layout->content = View::make('backoffice.account')
                    ->with('flash_message', 'No this account')
                    ->with('accounts', '')
                    ->with('properties', '')
                    ->with('settings', '');
            }
        } else {
            $this->layout->content = View::make('backoffice.account')
                ->with('flash_message', 'why you search for nothing.')
                ->with('accounts', '')
                ->with('properties', '')
                ->with('settings', '');
        }
    }

}
