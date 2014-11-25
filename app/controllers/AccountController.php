<?php
use Repository\AccountRepository;
use Repository\PropertyRepository;
use Repository\PaymentRepository;

class AccountController extends BaseController {

    protected $layout = "layout.main";
    protected $dashboard = "account.dashboard";
    protected $account;

    public function __construct(AccountRepository $account, PropertyRepository $property)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getDashboard')));
        $this->account = $account;
        $this->property = $property;
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

    //    public function getForgetpassword()
    //    {
    //        $this->layout->content = View::make('account.forgetpassword');
    //    }

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

    public function postEdit()
    {

        if (Auth::check())
        {

            if (input::get('identity') == 'user')
            {
                $validator = Validator::make(Input::all(), Account::$UserEditRules);
            } elseif (input::get('identity') == 'agent')
            {
                $validator = Validator::make(Input::all(), Account::$AgentEditRules);
            }

            if ($validator->passes())
            {
                $this->account->editAccount();
                Flash::success('資料更新了');

                return Redirect::to('account/dashboard/account_edit')->with('identity', input::get('identity'));
            } else
            {
                Flash::error('發生錯誤');

                return Redirect::to('account/dashboard/account_edit')->with('identity', input::get('identity'));
            }
        }
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
                Flash::error('密碼不一致');

                return Redirect::to('account/dashboard/account_edit');
            } else
            {

                $validator = Validator::make(Input::all(), Account::$PasswordRules);
                if ($validator->passes())
                {

                    $saveNewPassword = $this->account->saveNewPassword($newPassword);

                    if ($saveNewPassword == 'ok')
                    {
                        Flash::success('密碼以經更新');

                        return Redirect::to('account/dashboard/account_edit');
                    } else
                    {
                        throw new Exception("Error Processing Request", 1);
                        $this->layout->content = View::make('system.error');
                    }
                } else
                {
                    Flash::error('密碼過於簡單，請用更安全的密碼');

                    return Redirect::to('account/dashboard/account_edit');
                }
            }
        } else
        {
            Flash::error('原密碼不符。');

            return Redirect::to('account/dashboard/account_edit');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        Flash::success('以經安全登出');
        if (Auth::check())
        {
            Auth::logout();

            return Redirect::to('/');
        } else
        {
            return Redirect::to('/');
        }
    }

    public function getDashboard($dashboard_content)
    {

        $account = $this->account->lookUpAccountByID(Auth::user()->id);
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

            $this->layout->content = View::make('account.dashboard')->with('dashboard_content', $dashboard_content)->with('properties', $properties)->with('photos', $photos)->with('nosProperty', $nos_active_property)->with('showPropertyRequest', $showPropertyRequest)->with('requests', $request)->with('account', $account);


        } elseif ($dashboard_content == 'payment')
        {

            $payments = PaymentRepository::loadPaymentHistoryByAccountId(Auth::user()->id);

            $this->layout->content = View::make('account.dashboard')
                ->with('payments', $payments)
                ->with('account', $account)
                ->with('nosProperty', $nos_active_property)
                ->with('dashboard_content', $dashboard_content);

        } elseif ($dashboard_content == 'permission_deny')
        {

            $this->layout->content = View::make('account.dashboard')->with('account', $account)->with('nosProperty', $nos_active_property)->with('dashboard_content', $dashboard_content);


        } elseif ($dashboard_content == 'activity_log')
        {

            $activity_log = $this->account->loadActivityLog();

            if (sizeof($activity_log == 0))
            {
                $activity_log = 'null';
            }

            $this->layout->content = View::make('account.dashboard')
                ->with('account', $account)
                ->with('nosProperty', $nos_active_property)
                ->with('activity_log', $activity_log)
                ->with('dashboard_content', $dashboard_content);


        } elseif ($dashboard_content == 'account_setting')
        {
            $identity = $this->account->checkIdentity();
            if ($identity == 'agent')
            {
                $templates = $this->account->loadTemplate();
                if (sizeof($templates) == 0)
                {
                    $template = ['template' => 'no_template'];
                }
                $setting = null;
                $region = null;
                $category = null;
            } elseif ($identity == 'user')
            {
                $setting = $this->account->loadSetting();
                $region = $this->account->loadRegionList();
                $category = $this->account->loadCategoryList();
                $templates = null;
            }
            $this->layout->content = View::make('account.dashboard')
                ->with('account', $account)
                ->with('nosProperty', $nos_active_property)
                ->with('dashboard_content', $dashboard_content)
                ->with('identity', $identity)->with('setting', $setting)
                ->with('regions', $region)->with('categories', $category)->with('templates', $templates);
        } elseif ($dashboard_content == 'account_edit')
        {

            $this->layout->content = View::make('account.dashboard')->with('account', $account)->with('nosProperty', $nos_active_property)->with('dashboard_content', $dashboard_content);
        }
    }

    public function getLookUpAccount($account_id, $responsible_id)
    {

        $account = $this->account->lookUpAccountByID($account_id);

        $showContact = $this->account->checkDisclose($account, $responsible_id);

        if ($account->identity == 1)
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
            ->with('account', $account)
            ->with('showContact', $showContact)
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
            $category = null;
        } elseif ($account == 'user')
        {
            $setting = $this->account->loadSetting();
            $region = $this->account->loadRegionList();
            $category = $this->account->loadCategoryList();
            $template = null;
        }

        $this->layout->content = View::make('account.setting')->with('account', $account)->with('setting', $setting)->with('regions', $region)->with('categories', $category)->with('templates', $template);
    }

    public function postConfig()
    {

        $validator = Validator::make(Input::all(), Account::$UserSettingRules);
        if ($validator->passes())
        {
            $this->account->configSetting();
            Flash::success('設定成功');

            return Redirect::to('account/dashboard/account_setting')->withInput();
        } else
        {
            Flash::error('以下錯誤發生了');

            return Redirect::to('account/dashboard/account_setting')->withErrors($validator)->withInput();
        }
    }

    public function postCreate()
    {

        $identity = Input::get('identity');

        if ($identity == 'user')
        {
            $validator = Validator::make(Input::all(), Account::$UserRegisterRules);
        } elseif ($identity == 'agent')
        {
            $validator = Validator::make(Input::all(), Account::$AgentRegisterRules);
        }

        if ($validator->passes())
        {

            if ( ! Auth::check())
            {
                if ($identity == 'agent')
                {
                    $identityCode = 1;
                } elseif ($identity == 'user')
                {
                    $identityCode = 0;
                }
                $this->account->createAccount($identityCode);

                Flash::success('注冊成功，謝謝。');

                return Redirect::to('account/login');
            }
        } else
        {
            if ( ! Auth::check())
            {
                Flash::error('以下錯誤發生了');
                if ($identity == 'user')
                {
                    return Redirect::to('account/userregister')->withErrors($validator)->withInput();
                } elseif ($identity == 'agent')
                {
                    return Redirect::to('account/agentregister')->withErrors($validator)->withInput();
                }
            }
        }
    }

    public function postSignin()
    {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true))
        {
            $identity = $this->account->checkIdentity();

            //tasks
            // lay down 3 month post
            $this->property->layDownOldProperty(Config::get('nestq.POST_PERIOD'));
            Flash::success('您以成功登入');
            if ($identity == 'user')
            {
                return Redirect::to('/');
            } elseif ($identity == 'agent')
            {
                return Redirect::to('account/dashboard/property')->with('identity', $identity);
            }
        } else
        {
            Flash::error('未能登入，您的用戶電郵或密碼不正確');

            return Redirect::to('account/login')->withInput();
        }
    }

    public function postTemplate()
    {

        $validator = Validator::make(Input::all(), Account::$AgentTemplateRules);
        if ($validator->passes())
        {
            $template = $this->account->saveTemplate();
            Flash::success('您的代理請求範本更新了');

            return Redirect::to('account/dashboard/account_setting');
        } else
        {
            Flash::error('以下錯誤發生了');

            return Redirect::to('account/dashboard/account_setting');
        }
    }

    public function postProfilepic()
    {


        $validator = Validator::make(Input::all(), Account::$ProfilePicRules);

        if ($validator->fails())
        {
            Flash::error('相片檔案太大了');

            return Redirect::to('account/dashboard/account_edit');
        }

        // save & make thumbnail
        $upload_success = $this->account->saveProfilePic();

        if ($upload_success)
        {
            return Redirect::to('account/dashboard/account_edit');
        } else
        {
            Flash::error('以下錯誤發生了');

            return Redirect::to('account/dashboard/account_edit')->with('flash_message', '以下錯誤發生了');
        }
    }

    public function postRank()
    {
        $rank = $this->account->rankAgent();
        Flash::success('謝謝，您以支持了這位代理');

        return Redirect::action('AccountController@getLookUpAccount', array($rank));
    }
}
