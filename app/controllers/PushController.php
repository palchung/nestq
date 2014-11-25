<?php


//use DateTime;
//use Repository\PushRepository;


class PushController extends BaseController {

    protected $layout = "layout.main";
    protected $push;

    /*
      public function __construct(PushRepository $push) {
      $this->push = $push;
      }
     */

    public function ActivePush()
    {

        header("Content-Type: text/event-stream\n\n");
        header('Cache-Control: no-cache');

        $selected = [];
        $propertyId = $this->loadActiveProperty();


//        if (in_array($propertyId, $selected))
//        {
//            do
//            {
//                $propertyId = $this->loadActiveProperty();
//            } while (in_array($propertyId, $selected) == false);
//        }
//        array_push($selected, $propertyId);


        $property = $this->loadPropertyData($propertyId);

        // update property stat
//        $this->updatePropertyStat($property->property_id);


        $photoFile = $this->loadPropertyThumbnail($property->property_photo);

        $msg = [
            "id"         => $property->property_id,
            "name"       => $property->property_name,
            "actualsize" => $property->property_actualsize,
            "price"      => $property->property_price,
            "rentprice"  => $property->property_rentprice,
            "photoPath"  => $property->property_photo,
            "photoFile"  => $photoFile,
            "region"     => $property->region_name,
            "category"   => $property->category_name,
            "address"    => $property->property_address
        ];
//        $msg = [
//          "hi" => 'hi'
//        ];
        $this->pushMessage($msg);
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


    public function updatePropertyStat($propertyId)
    {
        if ($propertyId)
        {
            $stat = PropertyStat::firstOrCreate(array('property_id' => $propertyId));
            $stat->activepush = $stat->activepush + 1;
            $stat->save();

            return true;

        } else
        {
            return false;
        }

    }

    public function pushMessage($msg)
    {
        echo "retry: " . Config::get('nestq.ACTIVE_PUSH_INTERVAL') . "\n\n";
        echo "data:" . json_encode($msg) . "\n\n";

        echo "data:" . $msg . PHP_EOL;
        // echo PHP_EOL;
        ob_flush();
        flush();
//        sleep(Config::get('nestq.ACTIVE_PUSH_INTERVAL'));
//        sleep(1000000); //1000000 = 1 seconds
    }

    public function loadPropertyData($property_id)
    {

        $property = DB::table('property')
            ->join('region', 'property.region_id', '=', 'region.id')
            ->join('category', 'property.category_id', '=', 'category.id')
            ->select([
                'property.id as property_id',
                'property.name as property_name',
                'property.address as property_address',
                'property.actualsize as property_actualsize',
                'property.price as property_price',
                'property.rentprice as property_rentprice',
                'property.photo as property_photo',
                'category.name as category_name',
                'region.name as region_name'
            ])
            ->where('property.id', '=', $property_id)
//            ->where('category.active', '=', 1)
//            ->where('region.active', '=', 1)
            ->groupBy('property.id')
            ->get();

        return $property[0];
    }

    public function loadActiveProperty()
    {

        $this->selected = [];
        $this->region = Session::get('region', null);
        $this->category = Session::get('category', null);
        $this->rent = Session::get('rent');
        $this->sale = Session::get('sale');
        $this->user = Session::get('user');
        $this->agent = Session::get('agent');
        $this->price = Session::get('price', '');
        $this->priceRange = Session::get('priceRange', '');
        $this->rentprice = Session::get('rentprice', '');
        $this->rentpriceRange = Session::get('rentpriceRange', '');
        $this->actualsize = Session::get('actualsize', '');
        $this->sizeRange = Session::get('sizeRange', '');

        $query = DB::table('property');

        if ( ! ( ! empty($this->user) && ! empty($this->agent)))
        {
            if ( ! empty($this->user) || ! empty($this->agent))
            {
                $query->join('account', 'property.responsible_id', '=', 'account.id');
            }

            if ( ! empty($this->user))
            {
                $query->where('account.identity', '=', 0); //property ppst from user
            } elseif ( ! empty($this->agent))
            {
                $query->where('account.identity', '=', 1); //property post from agent
            }
        }
        if ( ! is_null($this->region))
        {
            $query->join('region', 'property.region_id', '=', 'region.id');
            $query->whereIn('region.id', $this->region);
            $query->where('region.active', '=', 1);
        }
        if ( ! is_null($this->category))
        {
            $query->join('category', 'property.category_id', '=', 'category.id');
            $query->whereIn('category.id', $this->category);
            $query->where('category.active', '=', 1);
        }
        if ( ! ( ! empty($this->rent) && ! empty($this->sale)))
        {
            if ( ! empty($this->rent))
            {
                $y = Array(0, 2); // 0 stand for rental
                $seeking_rental = true;
            } elseif ( ! empty($this->sale))
            {
                $y = Array(1, 2);
            } else
            {
                $y = Array(0, 1, 2);
                $seeking_rental = true;
            }
            $query->whereIn('property.soldorrent', $y);
        }

        if ( ! empty($this->price))
        {
            $priceUpper = $this->price + $this->priceRange;
            $priceLower = $this->price - $this->priceRange;
            $query->where('property.price', '<=', $priceUpper);
            $query->where('property.price', '>=', $priceLower);
        }

        if ($seeking_rental && ! empty($this->rentprice))
        {
            $rentpriceUpper = $this->rentprice + $this->rentpriceRange;
            $rentpriceLower = $this->rentprice - $this->rentpriceRange;
            $query->where('property.rentprice', '<=', $rentpriceUpper);
            $query->where('property.rentprice', '>=', $rentpriceLower);
        }
        if ( ! empty($this->actualsize))
        {
            $areaUpper = $this->actualsize + $this->sizeRange;
            $areaLower = $this->actualsize - $this->sizeRange;
            $query->where('property.actualsize', '<=', $areaUpper);
            $query->where('property.actualsize', '>=', $areaLower);
        }

        $query->select([
            'property.id as property_id',
        ]);

        // check if the user paid for active push
        $query->join('service', 'property.responsible_id', '=', 'service.account_id');
        $query->where('service.item_id', '=', Config::get('nestq.ACTIVE_PUSH_ID'));
        $query->where('service.period', '>', new DateTime('today'));

        $query->where('property.publish', '=', 1);
        $query->groupBy('property.id');
        $query->orderBy('property.updated_at', 'desc');

        $result = $query->get();


        $nos_of_properties = sizeof($result);
        $i = rand(0, $nos_of_properties - 1);
        $property_id = $result[$i]->property_id;


        // if (in_array($property_id, $this->selected))
        // {
        //     do
        //     {
        //         $i = rand(0, $nos_of_properties - 1);
        //         $property_id = $result[$i]->property_id;
        //     } while (in_array($property_id, $this->selected) == false);
        // }

        // $this->selected = array_push($this->selected, $property_id);

        return $property_id;
    }

    public function CountActivePush()
    {

        $countActivePush = $this->updatePropertyStat(Input::get('propertyId'));
        if ($countActivePush)
        {
            return Response::json(array('response' => $countActivePush));
        } else
        {
            return Response::json(array('response' => false));
        }


    }

}
