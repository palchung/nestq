<?php

use Repository\IndexRepository;

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function ($request)
{
    // $myApp Singleton object

    App::singleton('Nestq', function ()
    {

        $app = new stdClass;
        $app->title = "NestQ";
        if (Auth::check())
        {
            $app->account = Auth::User();
            $app->isLogedin = true;
        } else
        {
            $app->isLogedin = false;
            $app->account = false;
        }

        return $app;
    });
    $Nestq = App::make('Nestq');
    View::share('Nestq', $Nestq);

    // XSS prevention
    Input::merge(array_strip_tags(Input::all()));

    //trim all input
    // Input::merge(array_map('trim', Input::all()));

});


App::after(function ($request, $response)
{
    // Prevent Back Login After Logout by hitting the Back button
    $response->headers->set("Cache-Control", "no-cache,no-store, must-revalidate");
    $response->headers->set("Pragma", "no-cache"); //HTTP 1.0
    $response->headers->set("Expires", " Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function ()
{
    if (Auth::guest())
        return Redirect::guest('account/login');
});

Route::filter('admin', function ()
{
    if ( Auth::guest() || ! Auth::user()->permission < 3)
        return Redirect::guest('/');
});


Route::filter('auth.basic', function ()
{
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function ()
{
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function ()
{
    if (Session::token() != Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});


View::composer('layout.main', function ($view)
{

    // pass search box data to all view
    $territory = IndexRepository::loadTerritoryList();
    $region = IndexRepository::loadRegionList();
    $category = IndexRepository::loadCategoryList();
    $facility = IndexRepository::loadFacilityList();
    $view->with('territories', $territory)->with('regions', $region)->with('categories', $category)->with('facilities', $facility);
});
