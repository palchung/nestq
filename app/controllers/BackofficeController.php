<?php

use Repository\BackofficeRepository;

class BackofficeController extends BaseController {

    protected $layout = "layout.backoffice";
    protected $backoffice;

    public function __construct(BackofficeRepository $backoffice)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('on' => array('post', 'get')));
        $this->backoffice = $backoffice;
    }

    public function getDashboard()
    {
        $this->layout->content = View::make('backoffice.dashboard');
    }

    public function getLogin()
    {

        $this->layout->content = View::make('backoffice.login');
    }

    public function getLogout()
    {
        if (Auth::check())
        {
            Auth::logout();

            return Redirect::to('/')->with('flash_message', 'Your are now logged out!');

        }

    }

    public function IndexAction()
    {
        if (Auth::check())
        {
            Auth::logout();
        }
        $this->layout->content = View::make('backoffice.login');


    }

    public function getContent()
    {
        $this->layout->content = View::make('backoffice.content');
    }

    public function postLogin()
    {


        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), false))
        {

            $email = Input::get('email');
            $permission = $this->backoffice->checkPermission($email);

            if ($permission <= 2)
            { // 3 = normal user
                return Redirect::to('backoffice/dashboard');
            } else
            {
                return Redirect::to('/')->with('flash_message', 'You have no permission to login!');
            }
        } else
        {
            return Redirect::to('backoffice/login')
                ->with('flash_message', 'Your username/password combination was incorrect')
                ->withInput();
        }

    }

}
