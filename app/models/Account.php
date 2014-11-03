<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Account extends Eloquent implements UserInterface, RemindableInterface {

    public static $UserRegisterRules = array(
        //register
        'firstname'             => 'required|alpha|min:2',
        'lastname'              => 'required|alpha|min:2',
        'email'                 => 'required|email|unique:account',
        'tel'                   => 'integer|digits:8',
        'password'              => 'required|alpha_num|digits_between:8,12|confirmed',
        'password_confirmation' => 'required|alpha_num|digits_between:8,12',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:2'
    );
    public static $AgentRegisterRules = array(
        //register
        'firstname'             => 'required|alpha|min:2',
        'lastname'              => 'required|alpha|min:2',
        'email'                 => 'required|email|unique:account',
        'cell_tel'              => 'integer|digits:8|unique:account',
        'tel'                   => 'integer|digits:8',
        'license'               => 'required|alpha|min:2|unique:account',
        'company'               => 'alpha|min:2',
        'description'           => 'alpha|min:2',
        'password'              => 'required|alpha_num|digits_between:8,12|confirmed',
        'password_confirmation' => 'required|alpha_num|digits_between:8,12',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:2'
    );
    public static $UserEditRules = array(
        //register
        'firstname'             => 'required|alpha|min:2',
        'lastname'              => 'required|alpha|min:2',
        'tel'                   => 'integer|digits:8',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:2'
    );
    public static $AgentEditRules = array(
        //register
        'firstname'             => 'required|alpha|min:2',
        'lastname'              => 'required|alpha|min:2',
        'cell_tel'              => 'integer|digits:8|unique:account',
        'tel'                   => 'integer|digits:8',
        'license'               => 'required|alpha|min:2|unique:account',
        'company'               => 'alpha|min:2',
        'description'           => 'alpha|min:2',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:2'
    );
    public static $PasswordRule = array(
        //change password
        'existing'              => 'required|alpha_num|digits_between:8,12',
        'newPassword'           => 'required|alpha_num|digits_between:8,12|confirmed',
        'password_confirmation' => 'required|alpha_num|digits_between:8,12',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:2'
    );
    public static $ProfilePicRules = array(
        'profilePic' => 'image|max:3000',

    );
    public static $UserSettingRules = array(
//        'price'      => 'required|integer|digits_between:2,4',
//        'rentprice'  => 'required|integer|digits_between:3,6',
//        'actualsize' => 'required|integer|digits_between:3,5',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:5'
    );
    public static $AgentTemplateRules = array(
        'template' => 'required|alpha|min:2',
        //spam prevention
        'my_name'   => 'honeypot',
        'my_time'   => 'required|honeytime:2'
    );


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'account';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function setting()
    {
        return $this->hasOne('Setting');
    }

    public function conversation()
    {
        return $this->belongsToMany('Conversation', 'conversation_account');
    }


}
