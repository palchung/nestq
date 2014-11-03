<?php
use Repository\AccountRepository;
use Repository\PropertyRepository;
use Repository\PaymentRepository;

class AccountController extends BaseController
{

    protected $layout = "layout.main";
    protected $dashboard = "account.dashboard";
    protected $account;

    public function __construct(AccountRepository $account) {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getDashboard')));
        $this->account = $account;
    }

    public function getError() {
        $this->layout->content = View::make('account.error');
    }

    public function getAgentregister() {
        if (Auth::check()) {
            Auth::logout();
            $this->layout->content = View::make('account.register_agent');
        } else {
            $this->layout->content = View::make('account.register_agent');
        }
    }

    public function getUserregister() {

        if (Auth::check()) {
            Auth::logout();
            $this->layout->content = View::make('account.register_user');
        } else {
            $this->layout->content = View::make('account.register_user');
        }
    }

    //    public function getForgetpassword()
    //    {
    //        $this->layout->content = View::make('account.forgetpassword');
    //    }

    public function getLogin() {

        if (Auth::check()) {
            Auth::logout();
            $this->layout->content = View::make('account.login');
        } else {
            $this->layout->content = View::make('account.login');
        }
    }

    public function getEdit() {

        $account = Account::findOrFail(Auth::user()->id);
        $this->layout->content = View::make('account.edit')->with('account', $account);
    }

    public function postEdit() {

        if (Auth::check()) {

            if (input::get('identity') == 'user') {
                $validator = Validator::make(Input::all(), Account::$UserEditRules);
            } elseif (input::get('identity') == 'agent') {
                $validator = Validator::make(Input::all(), Account::$AgentEditRules);
            }

            if ($validator->passes()) {
                $this->account->editAccount();

                return Redirect::to('account/dashboard/account_edit')->with('flash_message', '資料更新了')->with('identity', input::get('identity'));
            } else {
                return Redirect::to('account/dashboard/account_edit')->with('flash_message', '發生錯誤')->with('identity', input::get('identity'));
            }
        }
    }

    public function postChangepassword() {

        $existingPassword = Input::get('existing');
        $newPassword = Input::get('newPassword');
        $password_confirmation = Input::get('password_confirmation');

        $checkExistingPassword = $this->account->checkExistingPassword($existingPassword);

        if ($checkExistingPassword == 'ok') {

            if ($newPassword != $password_confirmation) {
                return Redirect::to('account/dashboard/account_edit')->with('flash_message', '密碼不一致');
            } else {

                $validator = Validator::make(Input::all(), Account::$PasswordRules);
                if ($validator->passes()) {

                    $saveNewPassword = $this->account->saveNewPassword($newPassword);

                    if ($saveNewPassword == 'ok') {
                        return Redirect::to('account/dashboard/account_edit')->with('flash_message', '密碼以經更新');
                    } else {
                        throw new Exception("Error Processing Request", 1);
                        $this->layout->content = View::make('system.error');
                    }
                } else {
                    return Redirect::to('account/dashboard/account_edit')->with('flash_message', '密碼過於簡單，請用更安全的密碼');
                }
            }
        } else {
            return Redirect::to('account/dashboard/account_edit')->with('flash_message', '原密碼不符。');
        }
    }

    public function getLogout() {
        Auth::logout();

        if (Auth::check()) {
            Auth::logout();

            return Redirect::to('/')->with('flash_message', '以經安全登出');
        } else {
            return Redirect::to('/')->with('flash_message', '以經安全登出');
        }
    }

    public function getDashboard($dashboard_content) {

        $query = $this->account->lookUpAccountByID(Auth::user()->id);
        $nos_active_property = $this->account->loadActivePropertyByAccount(Auth::user()->id);

        if ($dashboard_content == 'property') {
            $properties = $this->account->loadPropertyByAccount();
            $identity = $this->account->checkIdentity();

            if ($identity == 'user') {
                $request = $this->account->loadRequestByAccount();
                $showPropertyRequest = 'yes';
            } else {
                $showPropertyRequest = 'no';
                $request = null;
            }
            $photos = [];
            foreach ($properties as $property) {
                $photos[$property->property_id] = PropertyRepository::loadPropertyThumbnail($property->property_photo);
            }

            if (sizeof($properties) == 0) {
                $properties = 'null';
            }

            $this->layout->content = View::make('account.dashboard')->with('dashboard_content', $dashboard_content)->with('properties', $properties)->with('photos', $photos)->with('nosProperty', $nos_active_property)->with('showPropertyRequest', $showPropertyRequest)->with('requests', $request)->with('account', $query['account'][0]);
        } elseif ($dashboard_content == 'payment') {

            $payments = PaymentRepository::loadPaymentHistoryByAccountId(Auth::user()->id);

            $this->layout->content = View::make('account.dashboard')->with('payments', $payments)->with('account', $query['account'][0])->with('nosProperty', $nos_active_property)->with('dashboard_content', $dashboard_content);
        } elseif ($dashboard_content == 'permission_deny') {

            $this->layout->content = View::make('account.dashboard')->with('account', $query['account'][0])->with('nosProperty', $nos_active_property)->with('dashboard_content', $dashboard_content);
        } elseif ($dashboard_content == 'account_setting') {
            $identity = $this->account->checkIdentity();
            if ($identity == 'agent') {
                $templates = $this->account->loadTemplate();
                if (sizeof($templates) == 0) {
                    $template = ['template' => 'no_template'];
                }
                $setting = null;
                $region = null;
                $category = null;
            } elseif ($identity == 'user') {
                $setting = $this->account->loadSetting();
                $region = $this->account->loadRegionList();
                $category = $this->account->loadCategoryList();
                $templates = null;
            }
            $this->layout->content = View::make('account.dashboard')->with('account', $query['account'][0])->with('nosProperty', $nos_active_property)->with('dashboard_content', $dashboard_content)->with('identity', $identity)->with('setting', $setting)->with('regions', $region)->with('categories', $category)->with('templates', $templates);
        } elseif ($dashboard_content == 'account_edit') {

            $this->layout->content = View::make('account.dashboard')->with('account', $query['account'][0])->with('nosProperty', $nos_active_property)->with('dashboard_content', $dashboard_content);
        }
    }

    public function getLookUpAccount($account_id) {

        $query = $this->account->lookUpAccountByID($account_id);

        if ($query['account'][0]->identity == 1) {
            $isAgent = true;
        } else {
            $isAgent = false;
        }

        if (Auth::check()) {

            //check if user ranked a agent
            if ($isAgent) {
                $checkRepeatRank = $this->account->checkRepeatRank($account_id);
                if ($checkRepeatRank == 'ok') {
                    $showRatingLink = true;
                } else {
                    $showRatingLink = false;
                }
            } else {
                $showRatingLink = false;
            }
        } else {
            $showRatingLink = false;
        }

        $this->layout->content = View::make('account.profile')

        //->with('identity', $identity)
        ->with('accounts', $query['account'])->with('showContact', $query['showContact'])->with('isAgent', $isAgent)->with('showRatingLink', $showRatingLink);
    }

    public function getSetting() {
        $account = $this->account->checkIdentity();

        if ($account == 'agent') {
            $template = $this->account->loadTemplate();
            if (sizeof($template) == 0) {
                $template = ['template' => 'no_template'];
            }
            $setting = null;
            $region = null;
            $category = null;
        } elseif ($account == 'user') {
            $setting = $this->account->loadSetting();
            $region = $this->account->loadRegionList();
            $category = $this->account->loadCategoryList();
            $template = null;
        }

        $this->layout->content = View::make('account.setting')->with('account', $account)->with('setting', $setting)->with('regions', $region)->with('categories', $category)->with('templates', $template);
    }

    public function postConfig() {

        $validator = Validator::make(Input::all(), Account::$UserSettingRules);
        if ($validator->passes()) {
            $this->account->configSetting();
            Session::flash('flash_message', 'your setting saved');

            return Redirect::to('account/dashboard/account_setting')->withInput();
        } else {
            return Redirect::to('account/dashboard/account_setting')->with('flash_message', '以下錯誤發生了')->withErrors($validator)->withInput();
        }
    }

    public function postCreate() {

        $identity = Input::get('identity');

        if ($identity == 'user') {
            $validator = Validator::make(Input::all(), Account::$UserRegisterRules);
        } elseif ($identity == 'agent') {
            $validator = Validator::make(Input::all(), Account::$AgentRegisterRules);
        }

        if ($validator->passes()) {

            if (!Auth::check()) {
                if ($identity == 'agent') {
                    $identityCode = 1;
                } elseif ($identity == 'user') {
                    $identityCode = 0;
                }
                $this->account->createAccount($identityCode);

                //                    $account = $this->account->sendNodificationMail();
                return Redirect::to('account/login')->with('flash_message', '注冊成功，謝謝。');
            }
        } else {
            if (!Auth::check()) {
                if ($identity == 'user') {
                    return Redirect::to('account/userregister')->with('flash_message', '以下錯誤發生了')->withErrors($validator)->withInput();
                } elseif ($identity == 'agent') {
                    return Redirect::to('account/agentregister')->with('flash_message', '以下錯誤發生了')->withErrors($validator)->withInput();
                }
            }
        }
    }

    public function postSignin() {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true)) {
            $identity = $this->account->checkIdentity();

            return Redirect::to('account/dashboard/property')->with('flash_message', '您以成功登入')->with('identity', $identity);
        } else {
            return Redirect::to('account/login')->with('flash_message', '未能登入，您的用戶電郵或密碼不正確')->withInput();
        }
    }

    public function postTemplate() {

        $validator = Validator::make(Input::all(), Account::$AgentTemplateRules);
        if ($validator->passes()) {
            $template = $this->account->saveTemplate();

            return Redirect::to('account/dashboard/account_setting')->with('flash_message', '您的代理請求範本更新了');
        } else {
            return Redirect::to('account/dashboard/account_setting')->with('flash_message', '以下錯誤發生了');
        }
    }

    public function postProfilepic() {

        //        $profile_pic = Input::all();
        $validator = Validator::make(Input::all(), Account::$ProfilePicRules);

        if ($validator->fails()) {
            return Redirect::to('account/dashboard/account_edit')->with('flash_message', '相片檔案太大了');
        }

        // save & make thumbnail
        $upload_success = $this->account->saveProfilePic();

        if ($upload_success) {
            return Redirect::to('account/dashboard/account_edit');
        } else {
            return Redirect::to('account/dashboard/account_edit')->with('flash_message', '以下錯誤發生了');
        }
    }

    public function postRank() {
        $rank = $this->account->rankAgent();
        Session::flash('flash_message', '謝謝，您以支持了這位代理');

        return Redirect::action('AccountController@getLookUpAccount', array($rank));
    }
}
