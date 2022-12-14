<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Carbon\Carbon;



class SendActiveMailCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'activemail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Active Mail to all registered users.';


    public function __construct()
    {
        parent::__construct();

    }


    public function fire()
    {
        $this->updateMailList();
        $target_user = $this->loadTargetUser();

        if ($target_user != 'no_user')
        {
            foreach ($target_user as $user)
            {

                $properties = $this->loadActiveMailProperties($user->account_id);

                if ($properties == 'no_property' || $properties == 'search_nothing')
                {


                    $data = [];
                    $data['properties'] = $properties;
                    Mail::send('account.mails.fake', $data, function ($message) use ($user)
                    {
                        $message->to('palchung@gmail.com', 'Pal Chung')
                        ->subject('物業報');
                    });


                    $this->saveMailList($user->account_id, 0);
                }
                else
                {
                    $data = [];
                    $photos = [];
                    foreach ($properties as $property)
                    {
                        $photos[$property->property_id] = $this->loadPropertyThumbnail($property->property_photo);
                    }

                    $data['properties'] = $properties;
                    $data['photos'] = $photos;

                    Mail::send('account.mails.activemail', $data, function ($message) use ($user)
                    {
                        $message->to($user->email, $user->firstname . ' ' . $user->lastname)
                        ->subject('物業報');
                    });

                    // 1 stand for successfully sent
                    $this->saveMailList($user->account_id, 1);


                }
            }
        }
    }

    public static function loadPropertyThumbnail($photoDir = null)
    {

        $dir = (string)(public_path() . '/upload/' . $photoDir . '/thumbnail/');

        $file_display = array('jpg', 'jpeg', 'png', 'gif');

        if (file_exists($dir) == false)
        {
            $photo = 'no_photo';
        } else
        {

            $dir_contents = scandir($dir);
            foreach ($dir_contents as $file)
            {
                $file_type = explode('.', $file);
                $file_extension = strtolower(end($file_type));

                if ($file !== '.' && $file !== '..' && in_array($file_extension, $file_display) == true)
                {

                    $photo = (string)($file);
                }
            }
        }

        return $photo;
    }

    public function updateMailList()
    {
        $now = Carbon::now();
        $lists = MailList::all();
        foreach ($lists as $list)
        {

            $date = date('Y-m-d H:i:s', strtotime($list->updated_at) + 7 * 86400);
            if ($date > $now) // should be <
            {
                $update = MailList::find($list->id);
                $update->sent = 0;
                $update->save();
            }
        }
    }


    public function saveMailList($account_id = null, $status = null)
    {

        MailList::where('account_id', '=', $account_id)
        ->update(array('sent' => $status, 'status' => $status));

        return;

    }



    public function loadActiveMailProperties($account_id)
    {



     $query = Setting::where('account_id','=', $account_id)->get();

     $setting = $query[0];




     if (sizeof($setting) != 0)
     {

       if ($setting->price != null)
       {
         $maillist_price = $setting->price;
     } else
     {
         $maillist_price = 300;
     }

     if ($setting->rentprice != null)
     {
         $maillist_rentprice = $setting->rentprice;
     } else
     {
         $maillist_rentprice = 6000;
     }
     if ($setting->actualsize != null)
     {
         $maillist_actualsize = $setting->actualsize;
     } else
     {
         $maillist_actualsize = 400;
     }


     if ($setting->source == 0)
     {
         $maillist_identity = 0;
     } elseif ($setting->source == 1)
     {
         $maillist_identity = 1;
     } elseif ($setting->source == 2)
     {
         $maillist_identity = 1;
     }

     if ($setting->soldorrent == 0)
     {
         $maillist_rent = 1;
     } elseif ($setting->soldorrent == 1)
     {
         $maillist_sale = 1;
     } elseif ($setting->soldorrent == 2)
     {
         $maillist_rent = 1;
         $maillist_sale = 1;
     }

     if ( ! empty($maillist_rent))
     {
               $y = Array(0, 2); // 0 stand for rental

           } elseif ( ! empty($maillist_sale))
           {
             $y = Array(1, 2);
         } else
         {
             $y = Array(0, 1, 2);

         }


         $priceUpper = $maillist_price + 50;
         $priceLower = $maillist_price - 50;
         $rentpriceUpper = $maillist_rentprice + 1000;
         $rentpriceLower = $maillist_rentprice - 1000;
         $areaUpper = $maillist_actualsize + 100;
         $areaLower = $maillist_actualsize - 100;


         $query = Property::join('account', 'property.responsible_id', '=', 'account.id')
         ->select([
             'property.id as property_id',
             'property.name as property_name',
             'property.created_at as property_created_at',
             'property.updated_at as property_updated_at',
             'property.responsible_id as property_responsible_id',
             'property.structuresize as property_structuresize',
             'property.actualsize as property_actualsize',
             'property.price as property_price',
             'property.rentprice as property_rentprice',
             'property.photo as property_photo',
             'property.geolocation as property_geolocation',
             'property.nosroom as property_nosroom',
             'property.noslivingroom as property_noslivingroom',
             'property.address as property_address',
             'property.floor as property_floor',
             'property.room as property_room',
             'property.block as property_block'
             ])
         // ->where('account.identity', '=', $maillist_identity)
         // ->whereIn('property.soldorrent', $y)
         // ->where('property.price', '<=', $priceUpper)
         // ->where('property.price', '>=', $priceLower)
         // ->where('property.rentprice', '<=', $rentpriceUpper)
         // ->where('property.rentprice', '>=', $rentpriceLower)
         // ->where('property.actualsize', '<=', $areaUpper)
         // ->where('property.actualsize', '>=', $areaLower)
         ->where('property.publish', '=', 1)
         ->groupBy('property.id')
         ->orderBy('property.updated_at', 'desc')
         ->take(10)
         ->get();

         $response = $query;

         if (sizeof($query) == 0)
         {
            $response = 'search_nothing';
        }

    } else
    {
     $response = 'no_setting';
 }

 $response = $response;

 return $response;


}


public function loadTargetUser()
{

    $target_user = DB::table('account')
    ->join('setting', 'setting.account_id', '=', 'account.id')
    ->join('maillist', 'maillist.account_id', '=', 'account.id')
    ->where('account.identity', '=', 0)
    ->where('setting.promotion_email', '=', 1)
    ->where('maillist.sent', '=', 0)
    ->take(10)
    ->get();

    if (sizeof($target_user) == 0)
    {
        $target_user = 'no_user';
    }

    return $target_user;
}


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('example', InputArgument::REQUIRED, 'An example argument.'),
            );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
            );
    }

}

