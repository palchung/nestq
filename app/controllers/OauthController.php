<?php

use Repository\OauthRepository;

class OauthController extends BaseController {

        protected $layout = "layout.main";
        protected $oauth;

        public function __construct(OauthRepository $oauth) {
                //$this->beforeFilter('csrf', array('on' => 'post'));
                //$this->beforeFilter('auth', array('only' => array('getAdd')));
                $this->oauth = $oauth;
        }

        /**
         * Login user with facebook
         *
         * @return void
         */
        public function getFacebook() {

                // get data from input
                $code = Input::get('code');

                // get fb service
                $fb = OAuth::consumer('Facebook');

                // check if code is valid
                // if code is provided get user data and sign in
                if (!empty($code)) {

                        // This was a callback request from facebook, get the token
                        $token = $fb->requestAccessToken($code);

                        // Send a request with it
                        $result = json_decode($fb->request('/me'), true);

                        $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];

                        $this->layout->content = View::make('frontpage.fake')
                                ->with('$message', $message)
                                ->with('result', $result);
                }
                // if not ask for permission first
                else {
                        // get fb authorization
                        $url = $fb->getAuthorizationUri();

                        // return to facebook login url
                        return Redirect::to((string) $url);
                }

                //handling erro
                $error = Input::get('error');

                if ($error) {
                        $message = "An error occurred logging you in with Facebook.";
                        if ($error == "access_denied") {
                                $message = "The access request on Facebook was denied.";
                        }
                        return Redirect::route('login')->with("error", $message);
                }
        }

        public function getGoogle() {

                // get data from input
                $code = Input::get('code');

                // get google service
                $googleService = OAuth::consumer('Google');

                // check if code is valid
                // if code is provided get user data and sign in
                if (!empty($code)) {

                        // This was a callback request from google, get the token
                        $token = $googleService->requestAccessToken($code);

                        // Send a request with it
                        $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);


                        $data = [
                            'email' => $result['email'],
                            'firstname' => $result['given_name'],
                            'lastname' => $result['family_name'],
                            'provider' => 'goog'
                        ];


                        $account = $this->oauth->saveOrLoginAccount($data);

                        Session::flash('flash_message', 'You have login');
                        $this->layout->content = View::make('frontpage.index');
                }
                // if not ask for permission first
                else {
                        // get googleService authorization
                        $url = $googleService->getAuthorizationUri();

                        // return to facebook login url
                        return Redirect::to((string) $url);
                }

                // handling error
                $error = Input::get('error');

                if ($error) {
                        $message = "An error occurred logging you in with Google.";
                        if ($error == "access_denied") {
                                $message = "The access request on Google was denied.";
                        }
                        return Redirect::route('account/error')->with("error", $message);
                }
        }

}
