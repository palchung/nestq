<?php

class RemindersController extends BaseController {

    protected $layout = "layout.main";

    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function getRemind()
    {
        return View::make('password.remind');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postRemind()
    {

        $response = Password::remind(Input::only('email'), function ($message)
        {
            $message->subject('重新設定 Nestq 登入密碼');
        });

        switch ($response)
        {
            case Password::INVALID_USER:
                Session::flash('flash_message', 'Invalid account');

//				return Redirect::back()->with('error', Lang::get($response));
                return Redirect::back();

//			case Password::REMINDER_SENT:
//				return Redirect::back()->with('status', Lang::get($response));

            case Password::REMINDER_SENT:
                Session::flash('flash_message', 'A reset password email sent');

                return Redirect::to('account/login');
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) App::abort(404);

        $this->layout->content = View::make('account.password_reset')->with('token', $token);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        $credentials = Input::only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($account, $password)
        {
            $account->password = Hash::make($password);

            $account->save();
        });

        switch ($response)
        {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                Session::flash('flash_message', Lang::get($response));

//				return Redirect::back()->with('error', Lang::get($response));
                return Redirect::back()->with('error', Lang::get($response));

            case Password::PASSWORD_RESET:
                Session::flash('flash_message', 'Password have Reset');

                return Redirect::to('/');
        }
    }

}
