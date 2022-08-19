<?php

namespace Repository;

use Account;
use MailList;
use Oauth;
use Property;
use Setting;
use Region;
use Category;
use Hash;
use Input;
use Auth;
use DB;
use Rating;
use Image;
use File;
use ActivityLog;


class AccountRepository {

    public static function createAccount($identity = null, $oauth = null, $permission = 3)
    {

        if ($oauth != null)
        {
            $firstname = $oauth['firstname'];
            $lastname = $oauth['lastname'];
            $email = $oauth['email'];
            $tel = '';
            $password = Hash::make($oauth['email']);
            $provider = $oauth['provider'];
        } else
        {
            $firstname = Input::get('firstname');
            $lastname = Input::get('lastname');
            $email = Input::get('email');
            $tel = Input::get('tel');
            $password = Hash::make(Input::get('password'));
        }


        $account = new Account;
        $account->password = $password;
        $account->identity = $identity;
        $account->firstname = $firstname;
        $account->lastname = $lastname;
        $account->email = $email;
        $account->tel = $tel;
        $account->permission = $permission;

        if ($identity == 1)
        {
            $account->cell_tel = Input::get('cell_tel');
            $account->company = Input::get('company');
            $account->license = Input::get('license');
            $account->description = Input::get('description');
        }
        $account->save();

        if ($identity == 0)
        {
            $setting = new Setting;
            $setting->account_id = $account->id;
            $setting->promotion_email = 1;
            $setting->disclose_contact = 0; // default not show contact
            $setting->agent_request = 1; // default allow agent request
            $setting->save();

            $mail_list = new MailList;
            $mail_list->account_id = $account->id;
            $mail_list->status = 0;
            $mail_list->sent = 0;
            $mail_list->save();

        }

        //Oauth for user
        if ($oauth != null)
        {
            $provider = new Oauth;
            $provider->account_id = $account->id;
            $provider->provider = $provider;
        }

        // register payment status
//                $service = new Service;
//                $service->account_id = $account->id;
//                $service->activepush = time() - 1; //ensure the time is in the past
//                $service->activemail = time() - 1;
//                $service->save();

        return $account->id;
    }

    public function editAccount()
    {
        $account = Account::findOrFail(Auth::user()->id);
        $account->firstname = Input::get('firstname');
        $account->lastname = Input::get('lastname');
        $account->email = Input::get('email');
        $account->tel = Input::get('tel');

        if ($account->identity == 1)
        {
            $account->cell_tel = Input::get('cell_tel');
            $account->company = Input::get('company');
            $account->license = Input::get('license');
            $account->description = Input::get('description');
        }
        $account->save();

        return;
    }

    public function sendNodificationMail()
    {

        /*
          Mail::send('account.mails.welcome', array('firstname' => Input::get('firstname')), function($message) {
          $message->to(Input::get('email'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Welcome to NestQ!');
          });
         */
return;
}


public function saveNewPassword($password)
{

    $password = Hash::make($password);
    $account = DB::table('account')
    ->where('id', Auth::user()->id)
            ->update(array('password' => $password)); // 1 stand for paid

            return 'ok';
        }


        public function checkExistingPassword($password)
        {

            $existingPassword = Account::find(Auth::user()->id)->password;

            if (Hash::check($password, $existingPassword))
            {
                return 'ok';
            } else
            {
                return 'no_ok';
            }

        }

        public function loadActivityLog(){



            $activity_log = DB::table('activitylog')
            ->join('property','property.id','=', 'activitylog.property_id')
            ->join('account','account.id','=','property.owner_id')
            ->select([
               'activitylog.property_id as proeprty_id',
               'activitylog.logcode_id as logcode_id',
               'property.name as property_name',
               'account.firstname as user_firstname',
               'account.lastname as user_lastname',
               ])
            ->where('activitylog.account_id','=', Auth::user()->id)
            ->get();

            return $activity_log;
        }



        public static function checkIdentity()
        {

            $account = Account::findOrFail(Auth::user()->id);
            if ($account->identity == 0)
            {
                return "user";
            } else
            {
                return "agent";
            }
        }


        public function saveProfilePic()
        {


            $account = Account::find(Auth::user()->id);

            if ($account->profile_pic)
            {
                $deletePath = public_path('profilepic/' . $account->profile_pic);
                $deleteThumbnailPath = public_path('profilepic/thumbnail/' . $account->profile_pic);
                File::delete($deletePath);
                File::delete($deleteThumbnailPath);
            }

            $image = Input::file('profilePic');
            $filename = sha1(time() . Auth::user()->email) . '.' . $image->getClientOriginalExtension();
            $path = public_path('profilepic/' . $filename);
            $thumbnail_path = public_path('profilepic/thumbnail/' . $filename);

            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            Image::make($image->getRealPath())->resize(50, 50)->save($thumbnail_path);

            $account = Account::find(Auth::user()->id);
            $account->profile_pic = $filename;
            $account->save();

            return true;

        }


        public function loadSetting()
        {

            $setting = Setting::where('account_id', '=', Auth::user()->id)->firstOrFail();

            return $setting;
        }

        public static function loadRegionList($whatToLoad = null)
        {
            $list = Region::where('active', '=', 1)->get();

            return $list;
        }

        public static function loadCategoryList($whatToLoad = null)
        {
            $list = Category::where('active', '=', 1)->get();

            return $list;
        }


        public function configSetting()
        {


            $settingId = Input::get('settingId');

            if (isset($settingId))
            {

                $setting = Setting::find((Input::get('settingId')));
                $setting->agent_request = Input::get('agent_request');
                $setting->promotion_email = Input::get('promotion_email');
                $setting->disclose_contact = Input::get('disclose_contact');
                $setting->price = Input::get('price');
                $setting->rentprice = Input::get('rentprice');
                $setting->soldorrent = Input::get('soldorrent');
                $setting->actualsize = Input::get('actualsize');
                $setting->source = Input::get('source');

                $setting->save();

                $regionChecked = Input::get('region');
                if (is_array($regionChecked))
                {
                    $setting->region()->sync($regionChecked);
                }

                $categoryChecked = Input::get('category');
                if (is_array($categoryChecked))
                {
                    $setting->category()->sync($categoryChecked);
                }

                return $setting;
            }
        }

        public function loadPropertyByAccount()
        {

            $properties = DB::table('property')
            ->join('propertystat', 'property.id', '=', 'propertystat.property_id')
            ->select([
                'property.id as property_id',
                'property.name as property_name',
                'property.created_at as property_created_at',
                'property.updated_at as property_updated_at',
                'property.owner_id as property_owner_id',
                'property.responsible_id as property_responsible_id',
                'property.structuresize as property_structuresize',
                'property.actualsize as property_actualsize',
                'property.price as property_price',
                'property.publish as property_publish',
                'property.rentprice as property_rentprice',
                'property.photo as property_photo',
                'property.geolocation as property_geolocation',
                'property.nosroom as property_nosroom',
                'property.noslivingroom as property_noslivingroom',
                'property.address as property_address',
                'property.floor as property_floor',
                'property.room as property_room',
                'property.block as property_block',
                'propertystat.view as view',
                'propertystat.conversation as conversation',
                'propertystat.activepush as activepush',
                'propertystat.activemail as activemail'
                ])
->where('property.responsible_id', '=', Auth::user()->id)
->where('property.owner_id', '=', Auth::user()->id)
->groupBy('property.id')
->get();


return $properties;
}


public static function loadActivePropertyByAccount($account_id)
{

    $nos = Property::where('owner_id', '=', $account_id)
    ->orWhere('responsible_id', '=', $account_id)
    ->where('publish', '=', 1)
    ->count();

    return $nos;
}

public static function loadNosOfResponsibleProperty($account_id)
{
    $nos = Property::where('responsible_id', '=', $account_id)
    ->where('publish', '=', 1)
    ->count();

    return $nos;
}


public function loadRequestByAccount()
{


    $request = DB::table('requisition')
    ->join('property', 'property.id', '=', 'requisition.property_id')
    ->select(
        'requisition.property_id', DB::raw('COUNT(requisition.property_id) as nosrequest')
        )
    ->where('property.owner_id', '=', Auth::user()->id)
    ->where('property.responsible_id', '=', Auth::user()->id)
    ->groupBy('requisition.id')
    ->get();

    return $request;
}

public function lookUpAccountByID($account_id)
{

    $account = DB::table('account')
    ->where('id', '=', $account_id)
    ->get();

    return $account[0];
}

public function checkDisclose($account = null, $responsible_id = null){


    if ($account->identity == 1)
    {
        $showContact = true;
    } elseif ($account->identity == 0)
    {
        $disclose_contact = DB::table('setting')
        ->where('account_id', '=', $account->id)
        ->pluck('disclose_contact');
        // 1 stand for allow disclosure
        if ($disclose_contact == 1)
        {
            $showContact = true;
        } elseif ($disclose_contact == 0)
        {

            if ($responsible_id == Auth::user()->id){
                $showContact = true;
            }else{
                $showContact = false;
            }
        }
    }


    return $showContact ;

}

public function checkContactPerssion($identity, $account_id){


    if($identity == 1)
    {
        $showContact = true;
    }elseif($identity == 0)
    {
       $disclose_contact = DB::table('setting')
       ->where('account_id', '=', $account_id)
       ->pluck('disclose_contact');

       if ($disclose_contact == 1)
       {
            $showContact = true;
        } elseif ($disclose_contact == 0)
        {

            $showContact = false;

        }
    }
    return $showContact;
}


public function saveTemplate()
{

    $account = Account::findorfail(Auth::user()->id);
    $account->template = Input::get('template');
    $account->save();

    return;
}

public static function loadTemplate()
{
    $template = DB::table('account')
    ->select('template')
    ->where('id', '=', Auth::user()->id)
    ->get();

//        $template = Account::find(Auth::user()->id)->template;

    return $template;
}

public static function checkRequestAllowance($property_id)
{
    $allowance = DB::table('property')
    ->join('setting', 'property.responsible_id', '=', 'setting.account_id')
    ->select(['setting.agent_request'])
    ->where('property.id', '=', $property_id)
    ->get();
    if ($allowance[0]->agent_request == 1)
    {
        return 'ok';
    } else
    {
        return 'not_ok';
    }
}

public function rankAgent()
{
    if (Auth::user()->identity == 0)
        {   // only user can rank
            $agent_id = Input::get('agentId');
            $check = AccountRepository::checkRepeatRank($agent_id);
            if ($check == 'ok')
            {

                $existRating = DB::table('account')->where('id', $agent_id)
                ->pluck('rating');


                $newRating = DB::table('account')
                ->where('id', $agent_id)
                ->update(array('rating' => $existRating + 1));

                $rating = new Rating;
                $rating->user_id = Auth::user()->id;
                $rating->agent_id = $agent_id;
                $rating->save();
            }
        }

        return $agent_id;
    }

    public function checkRepeatRank($agent_id)
    {
        $check = DB::table('rating')
        ->where('agent_id', '=', $agent_id)
        ->where('user_id', '=', Auth::user()->id)
        ->get();

        if (sizeof($check) == 0)
        {
            return 'ok';
        } else
        {
            return 'no_ok';
        }
    }


}
