<?php

use Repository\AccountRepository;
use Illuminate\Support\MessageBag;

use Repository\PropertyRepository;
use Repository\PaymentRepository;


class AccountController extends BaseController {

    protected $layout = "layout.main";
    protected $dashboard = "account.dashboard";
    protected $account;

    public function __construct(AccountRepository $account)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getDashboard')));
        $this->account = $account;
    }

    public function getError()
    {
        $this->layout->content = View::make('account.error');
    }

    public function getAgentregister()
    {
        if (Auth::check())
        {
            Auth::logout();
            $this->layout->content = View::make('account.register_agent');
        } else
        {
            $this->layout->content = View::make('account.register_agent');
        }

    }

    public function getUserregister()
    {

        if (Auth::check())
        {
            Auth::logout();
            $this->layout->content = View::make('account.register_user');
        } else
        {
            $this->layout->content = View::make('account.register_user');
        }

    }


    public function getForgetpassword()
    {
        $this->layout->content = View::make('account.forgetpassword');
    }

    public function getLogin()
    {


        if (Auth::check())
        {
            Auth::logout();
            $this->layout->content = View::make('account.login');
        } else
        {
            $this->layout->content = View::make('account.login');
        }


    }

    public function getEdit()
    {

        $account = Account::findOrFail(Auth::user()->id);
        $this->layout->content = View::make('account.edit')->with('account', $account);
    }


    public function postChangepassword()
    {

        $existingPassword = Input::get('existing');
        $newPassword = Input::get('newPassword');
        $password_confirmation = Input::get('password_confirmation');

        $checkExistingPassword = $this->account->checkExistingPassword($existingPassword);

        if ($checkExistingPassword == 'ok')
        {

            if ($newPassword != $password_confirmation)
            {
                return Redirect::to('account/dashboard/account_edit')->with('flash_message', 'confirm password not match');
            } else
            {

                $saveNewPassword = $this->account->saveNewPassword($newPassword);

                if ($saveNewPassword == 'ok')
                {
                    return Redirect::to('account/dashboard/account_edit')->with('flash_message', 'Password changed');
                } else
                {
                    throw new Exception("Error Processing Request", 1);
                    $this->layout->content = View::make('system.error');
                }
            }
        } else
        {
            return Redirect::to('account/dashboard/account_edit')->with('flash_message', 'existing password not match');
        }
    }


    public function getLogout()
    {
        Auth::logout();

        if (Auth::check())
        {
            Auth::logout();

            return Redirect::to('/')->with('flash_message', 'Your are now logged out!');
        } else
        {
            return Redirect::to('/')->with('flash_message', 'Your are now logged out!');
        }


    }

    public function getDashboard($dashboard_content)
    {


        $query = $this->account->lookUpAccountByID(Auth::user()->id);
        $nos_active_property = $this->account->loadActivePropertyByAccount(Auth::user()->id);

        if ($dashboard_content == 'property')
        {
            $properties = $this->account->loadPropertyByAccount();


            $identity = $this->account->checkIdentity();


            if ($identity == 'user')
            {
                $request = $this->account->loadRequestByAccount();
                $showPropertyRequest = 'yes';
            } else
            {
                $showPropertyRequest = 'no';
                $request = null;
            }

            $photos = [];
            foreach ($properties as $property)
            {
                $photos[$property->property_id] = PropertyRepository::loadPropertyThumbnail($property->property_photo);
            }


            if (sizeof($properties) == 0)
            {
                $properties = 'null';
            }


            $this->layout->content = View::make('account.dashboard')
            ->with('dashboard_content', $dashboard_content)
            ->with('properties', $properties)
            ->with('photos', $photos)
            ->with('nosProperty', $nos_active_property)
            ->with('showPropertyRequest', $showPropertyRequest)
            ->with('requests', $request)
            ->with('account', $query['account'][0]);

        } elseif ($dashboard_content == 'payment')
        {

            $payments = PaymentRepository::loadPaymentHistoryByAccountId(Auth::user()->id);

            $this->layout->content = View::make('account.dashboard')
            ->with('payments', $payments)
            ->with('account', $query['account'][0])
            ->with('nosProperty', $nos_active_property)
            ->with('dashboard_content', $dashboard_content);

        } elseif ($dashboard_content == 'permission_deny')
        {

            $this->layout->content = View::make('account.dashboard')
            ->with('account', $query['account'][0])
            ->with('nosProperty', $nos_active_property)
            ->with('dashboard_content', $dashboard_content);

        } elseif ($dashboard_content == 'account_setting')
        {
            $identity = $this->account->checkIdentity();
            if ($identity == 'agent')
            {
                $template = $this->account->loadTemplate();
                if (sizeof($template) == 0)
                {
                    $template = ['template' => 'no_template'];
                }
                $setting = null;
                $region = null;
            } elseif ($identity == 'user')
            {
                $setting = $this->account->loadSetting();
                $region = $this->account->loadRegionList();
                $template = null;
            }
            $this->layout->content = View::make('account.dashboard')
            ->with('account', $query['account'][0])
            ->with('nosProperty', $nos_active_property)
            ->with('dashboard_content', $dashboard_content)
            ->with('identity', $identity)
            ->with('setting', $setting)
            ->with('regions', $region)
            ->with('templates', $template);

        }
        elseif ($dashboard_content == 'account_edit')
        {

            $this->layout->content = View::make('account.dashboard')
            ->with('account', $query['account'][0])
            ->with('nosProperty', $nos_active_property)
            ->with('dashboard_content', $dashboard_content);


        }


    }



    public function getLookUpAccount($account_id)
    {

        $query = $this->account->lookUpAccountByID($account_id);

        if ($query['account'][0]->identity == 1)
        {
            $isAgent = true;
        } else
        {
            $isAgent = false;
        }

        if (Auth::check())
        {


            //check if user ranked a agent
            if ($isAgent)
            {
                $checkRepeatRank = $this->account->checkRepeatRank($account_id);
                if ($checkRepeatRank == 'ok')
                {
                    $showRatingLink = true;
                } else
                {
                    $showRatingLink = false;
                }
            } else
            {
                $showRatingLink = false;
            }
        } else
        {
            $showRatingLink = false;
        }


        $this->layout->content = View::make('account.profile')
            //->with('identity', $identity)
        ->with('accounts', $query['account'])
        ->with('showContact', $query['showContact'])
        ->with('isAgent', $isAgent)
        ->with('showRatingLink', $showRatingLink);
    }

    public function getSetting()
    {
        $account = $this->account->checkIdentity();

        if ($account == 'agent')
        {
            $template = $this->account->loadTemplate();
            if (sizeof($template) == 0)
            {
                $template = ['template' => 'no_template'];
            }
            $setting = null;
            $region = null;
        } elseif ($account == 'user')
        {
            $setting = $this->account->loadSetting();
            $region = $this->account->loadRegionList();
            $template = null;
        }

        $this->layout->content = View::make('account.setting')
        ->with('account', $account)
        ->with('setting', $setting)
        ->with('regions', $region)
        ->with('templates', $template);
    }

    public function postConfig()
    {

        $validator = Validator::make(Input::all(), Account::$settingRules);
        if ($validator->passes())
        {


            $setting = $this->account->configSetting();
            Session::flash('flash_message', 'your setting saved');

            return Redirect::to('account/dashboard/account_setting')->withInput();
        } else
        {
            return Redirect::to('account/dashboard/account_setting')->with('flash_message', 'The following errors occurred')->withErrors($validator)->withInput();
        }
    }

    public function postCreate()
    {

        $identity = Input::get('identity');


        if ($identity == 'agent')
        {


            if ( ! Auth::check())
            {

                $validator = Validator::make(Input::all(), Account::$registerAgentRules);
                if ($validator->passes())
                {
                    $identity = 1; // 1 stand for agent
                    $account = $this->account->createAccount($identity);
                    $account = $this->account->sendNodificationMail();

                    return Redirect::to('account/login')->with('flash_message', 'Thanks for registering!');
                } else
                {
                    return Redirect::to('account/agentregister')->with('flash_message', 'The following errors occurred')->withErrors($validator)->withInput();
                }
            } else
            {

                $validator = Validator::make(Input::all(), Account::$editAgentAccountRules);
                if ($validator->passes())
                {
                    $account = $this->account->editAccount();

                    return Redirect::to('account/dashboard/property')->with('flash_message', 'Account updated!')->with('identity', 'agent');
                } else
                {
                    return Redirect::to('account/dashboard/account_edit')->with('flash_message', 'The following errors occurred')->withErrors($validator)->withInput();
                }
            }
        } elseif ($identity == 'user')
        {


            if ( ! Auth::check())
            {

                $validator = Validator::make(Input::all(), Account::$registerUserRules);
                if ($validator->passes())
                {
                    $identity = 0;    // 0 stand for user
                    $account = $this->account->createAccount($identity);
                    $account = $this->account->sendNodificationMail();

                    return Redirect::to('account/login')->with('flash_message', 'Thanks for registering!');
                } else
                {
                    return Redirect::to('account/userregister')->with('flash_message', 'The following errors occurred')->withErrors($validator)->withInput();
                }
            } else
            {

                $validator = Validator::make(Input::all(), Account::$editUserAccountRules);
                if ($validator->passes())
                {
                    $account = $this->account->editAccount();

                    return Redirect::to('account/dashboard/property')->with('flash_message', 'Account updated!')->with('identity', 'user');
                } else
                {
                    return Redirect::to('account/dashboard/account_edit')->with('flash_message', 'The following errors occurred')->withErrors($validator)->withInput();
                }
            }
        }
    }


    public function postSignin()
    {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true))
        {
            $identity = $this->account->checkIdentity();

            return Redirect::to('account/dashboard/property')->with('flash_message', 'You are now logged in!')->with('identity', $identity);
        } else
        {
            return Redirect::to('account/login')
            ->with('flash_message', 'Your username/password combination was incorrect')
            ->withInput();
        }
    }

    public function postTemplate()
    {

        $validator = Validator::make(Input::all(), Account::$registerAgentRules);
        if ($validator->passes())
        {


            $template = $this->account->saveTemplate();

            return Redirect::to('account/dashboard/account_setting')->with('flash_message', 'Your Setting Updated');

        } else
        {
            return Redirect::to('account/dashboard/account_setting')->with('flash_message', 'The following errors occurred');

        }
    }


    public function postProfilepic()
    {
        $profile_pic = Input::all();
        $validator = Validator::make(Input::all(), Account::$settingRules);


        if ($validator->fails())
        {
            return Redirect::to('account/dashboard/account_edit')->with('flash_message', 'The following errors occurred');
        }

        $upload_success = $this->account->saveProfilePic();


        if( $upload_success ) {
            return Redirect::to('account/dashboard/account_edit');
        } else {
            return Redirect::to('account/dashboard/account_edit')->with('flash_message', 'The following errors occurred');
        }
    }







    public function postRank()
    {
        $rank = $this->account->rankAgent();
        Session::flash('flash_message', 'Thank You, you have ranked this agent');

        return Redirect::action('AccountController@getLookUpAccount', array($rank));
    }

    public function postResetpassword()
    {
        $data = [
        "requested" => Input::old("requested")
        ];

        $validator = Validator::make(Input::all(), Account::$registerUserRules);
        if ($validator->passes())
        {
            $credentials = [
            "email" => Input::get("email")
            ];
            Password::remind($credentials, function ($message, $user)
            {
                $message->from("hello@nestq.com");
            }
            );
            $data["requested"] = true;

            return Redirect::to('account/forgetpassword')->with('flash_message', 'A Reset mail have sent to your email account');
            /*
              return Redirect::route("account/request")
              ->withInput($data);

             */
          }

          $this->layout->content = View::make("account/request", $data)->with('flash_message', 'We cant read your email');
      }

      public function postReset()
      {
        $token = "?token=" . Input::get("token");
        $errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = [
        "token"  => $token,
        "errors" => $errors
        ];

        $validator = Validator::make(Input::all(), Account::$registerUserRules);
        if ($validator->passes())
        {
            $credentials = [
            "email" => Input::get("email")
            ];
            Password::reset($credentials, function ($user, $password)
            {
                $user->password = Hash::make($password);
                $user->save();
                Auth::login($user);

                return Redirect::to('account/dashboard/property')->with('flash_message', 'Welcome back');
                    /*
                      return Redirect::route("account/dashboard");
                     */
                  }
                  );
        }
        $data["email"] = Input::get("email");
        $data["errors"] = $validator->errors();

        return Redirect::to(URL::route("account/reset") . $token)
        ->withInput($data);
    }

}
