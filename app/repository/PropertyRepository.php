<?php

namespace Repository;

use Account;
use Property;
use Payment;
use Requisition;
use Facility;
use Transportation;
use Feature;
use Category;
use Region;
use Hash;
use Service;
use Input;
use Auth;
use DB;
use Config;
use PropertyStat;
use Intervention\Image;

class PropertyRepository {

    public function loadFeatureList($whatToLoad = null)
    {

        $list = Feature::where('active', '=', 1)->get();

        return $list;
    }

    public function loadTransportationList($whatToLoad = null)
    {

        $list = Transportation::where('active', '=', 1)->get();

        return $list;
    }

    public function loadFacilityList($whatToLoad = null)
    {

        $list = Facility::where('active', '=', 1)->get();

        return $list;
    }

    public function loadCategoryList($whatToLoad = null)
    {
        $list = DB::table('category')->where('active', '=', 1)->lists('name');

        return $list;
    }

    public function loadRegionList($whatToLoad = null)
    {
        $list = DB::table('region')->where('active', '=', 1)->lists('name');

        return $list;
    }

    public function checkIdentity()
    {

//$identity = Account::where('id', Auth::user()->id)->pluck('identity');

        $identity = Auth::user()->identity;

        if ($identity == 0)
        {
            return "user";
        } else
        {
            return "agent";
        }
    }

    public function checkPublishLimit($identity = null)
    {
        if ($identity == 'agent')
        {

            $service = Config::get('nestq.POSTING_PROPERTY_ID');
            $paid = Service::checkServicePayment($service);

            if ($paid == 'paid')
            {
                return 'ok';
            } else
            {
                $count = Property::where('owner_id', '=', Auth::user()->id)->where('publish', '=', '1')->count();
                $limit = Config::get('nestq.USER_PUBLISH_NOS');
                if ($count >= $limit)
                {
                    return 'not_ok';
                } else
                {
                    return 'ok';
                }
            }
        } elseif ($identity == 'user')
        {
            $count = Property::where('owner_id', '=', Auth::user()->id)->where('publish', '=', '1')->count();
            $limit = Config::get('nestq.USER_PUBLISH_NOS');
            if ($count >= $limit)
            {
                return 'not_ok';
            } else
            {
                return 'ok';
            }
        }
    }


    public function createProperty($propertyId)
    {


        if (isset($propertyId))
        {
            $property = Property::find((Input::get('propertyId')));

        } else
        {
            $property = new Property;
            $property->owner_id = Auth::user()->id;
        }
        $property->publish = 0; // 0 stand for not publish yet
        $property->responsible_id = Auth::user()->id;
        $property->name = Input::get('name');
        $property->deal = 0; // 0 stand for not deal yet
        $property->category_id = Input::get('category_id') + 1;
        $property->structuresize = Input::get('structuresize');
        $property->actualsize = Input::get('actualsize');
        $property->region_id = Input::get('region_id') + 1;
        $property->price = Input::get('price');
        $property->rentprice = Input::get('rentprice');
        $property->soldorrent = Input::get('soldorrent');
        $property->geolocation = Input::get('geolocation');
        $property->nosroom = Input::get('nosroom');
        $property->noslivingroom = Input::get('noslivingroom');
        $property->address = Input::get('address');
        $property->room = Input::get('room');
        $property->floor = Input::get('floor');
        $property->block = Input::get('block');
        $property->photo = Input::get('photo');
        $property->save();


        $stat = PropertyStat::firstOrNew(array('property_id' => $property->id));
        $stat->property_id = $property->id;
        $stat->save();

        $facilityChecked = Input::get('facilitiesList');
        if (is_array($facilityChecked))
        {
            $property->facility()->sync($facilityChecked);
        }

        $transportationChecked = Input::get('transportationsList');
        if (is_array($transportationChecked))
        {
            $property->transportation()->sync($transportationChecked);
        }

        $featureChecked = Input::get('featuresList');
        if (is_array($featureChecked))
        {
            $property->feature()->sync($featureChecked);
        }

        return $property;
    }

    public function loadPropertyData($propertyId = null)
    {
        $propertyData = Property::find($propertyId);

        return $propertyData;
    }

    public function publishProperty($property_id = null)
    {
        $property = Property::find($property_id);
        $property->publish = 1; // 1 stand for published
        $property->save();

        return 'ok';
    }

    public function laydownProperty($property_id = null)
    {
        $property = Property::find($property_id);
        $property->publish = 0; // 0 stand for not yet published
        $property->save();

        return 'ok';
    }


    public static function lookUpPropertyByID($property_id)
    {

        $property = DB::table('property')
            ->join('account', 'property.responsible_id', '=', 'account.id')
            ->join('region', 'property.region_id', '=', 'region.id')
            ->join('territory', 'region.territory_id', '=', 'territory.id')
            ->join('category', 'property.category_id', '=', 'category.id')
            ->join('property_facility', 'property.id', '=', 'property_facility.property_id')
            ->join('facility', 'property_facility.facility_id', '=', 'facility.id')
            ->join('property_transportation', 'property.id', '=', 'property_transportation.property_id')
            ->join('transportation', 'property_transportation.transportation_id', '=', 'transportation.id')
            ->join('property_feature', 'property.id', '=', 'property_feature.property_id')
            ->join('feature', 'property_feature.feature_id', '=', 'feature.id')
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
                'property.rentprice as property_rentprice',
                'property.photo as property_photo',
                'property.geolocation as property_geolocation',
                'property.nosroom as property_nosroom',
                'property.noslivingroom as property_noslivingroom',
                'property.address as property_address',
                'property.floor as property_floor',
                'property.room as property_room',
                'property.block as property_block',
                'account.id as account_id',
                'account.firstname as account_firstname',
                'account.lastname as account_lastname',
                'account.email as account_email',
                'account.cell_tel as account_cell_tel',
                'account.tel as account_tel',
                'account.identity as account_identity',
                'account.rating as account_rating',
                'account.profile_pic as account_profile_pic',
                'account.description as account_description',
                'account.license as account_license',
                'account.company as account_company',
                'category.name as category_name',
                'region.name as region_name',
                'territory.name as territory_name',
                'facility.name as facility_name',
                'transportation.name as transportation_name',
                'feature.name as feature_name'
            ])
            ->where('property.id', '=', $property_id)
            ->where('region.active', '=', 1)
            ->where('facility.active', '=', 1)
            ->where('transportation.active', '=', 1)
            ->where('feature.active', '=', 1)
            ->where('territory.active', '=', 1)
            ->where('category.active', '=', 1)
            ->groupBy('property.id')
            ->get();

        return $property;
    }

    public function checkRequest()
    {

        $propertyId = Input::get('propertyId');
        $identity = DB::table('property')->select('owner_id', 'responsible_id')->where('id', '=', $propertyId)->get();
        $request = DB::table('requisition')->where('property_id', '=', $propertyId)->where('agent_id', '=', Auth::user()->id)->get();
        $repeat_request = sizeof($request);

        if (($identity[0]->owner_id == $identity[0]->responsible_id) && ($repeat_request == 0))
        {
            return 'ok';
        } elseif ($repeat_request != 0)
        {
            return 'repeat';
        } else
        {
            return 'not_ok';
        }
    }

    public function checkRepeatRequest($property_id)
    {
        $request = DB::table('requisition')->where('property_id', '=', $property_id)->where('agent_id', '=', Auth::user()->id)->get();
        if (sizeof($request) == 0)
        {
            return 'no';
        } else
        {
            return 'yes';
        }
    }

    public function saveRequest()
    {

        $request = new Requisition;
        $request->property_id = Input::get('propertyId');
        $request->agent_id = Auth::user()->id;
        $request->requestmessage = Input::get('template');
        $request->save();

        return;
    }

    public function loadRequestByPropertyId($property_id)
    {

        $request = DB::table('requisition')
            ->join('account', 'requisition.agent_id', '=', 'account.id')
            ->select([
                'requisition.id as id',
                'requisition.created_at as created_at',
                'requisition.requestmessage as requestmessage',
                'account.firstname as agent_firstname',
                'account.lastname as agent_lastname',
                'account.email as agent_email',
                'account.cell_tel as agent_cell_tel',
                'account.tel as agent_tel',
                'account.rating as agent_rating',
                'account.company as agent_company',
                'account.description as agent_description',
                'account.profile_pic as agent_profile_pic',
                'account.last_seen as agent_last_seen'
            ])
            ->where('property_id', '=', $property_id)
            ->get();

        return $request;
    }

    public function checkOwnership($property_id)
    {

        $ownership = DB::table('property')->where('id', '=', $property_id)->where('owner_id', '=', Auth::user()->id)->get();
        if (sizeof($ownership) == 0)
        {
            return 'not_ok';
        } else
        {
            return 'ok';
        }
    }

    public function loadAgreementByRequestId()
    {
        $request_id = Input::get('requestId');

        $agreement = DB::table('requisition')
            ->join('account', 'requisition.agent_id', '=', 'account.id')
            ->join('property', 'requisition.property_id', '=', 'property.id')
            ->select([
                'requisition.id as requisition_id',
                'requisition.agent_id as requisition_agent_id',
                'account.firstname as agent_firstname',
                'account.lastname as agent_lastname',
                'account.email as agent_email',
                'account.cell_tel as agent_cell_tel',
                'account.tel as agent_tel',
                'account.rating as agent_rating',
                'account.company as agent_company',
                'account.description as agent_description',
                'account.profile_pic as agent_profile_pic',
                'account.last_seen as agent_last_seen',
                'property.name as property_name',
                'property.structuresize as property_structuresize',
                'property.actualsize as property_actualsize',
                'property.nosroom as property_nosroom',
                'property.noslivingroom as property_noslivingroom',
                'property.photo as property_photo',
                'property.price as property_price',
                'property.rentprice as property_rentprice',
                'property.id as property_id',
                'property.address as property_address',
                'property.floor as property_floor',
                'property.room as property_room',
                'property.block as property_block'])
            ->where('requisition.id', '=', $request_id)
            ->get();

        return $agreement;
    }

    public function handOverPropertyToAgent()
    {

        $request_id = Input::get('requestId');
        $agent_id = Input::get('agentId');
        $property_id = Input::get('propertyId');

        // update property responsible to agent
        DB::table('property')->where('id', '=', $property_id)->update(array('responsible_id' => $agent_id));

        // remove all request
        DB::table('requisition')->where('id', '=', $request_id)->delete();

        // inform agent, property has handed over
        return;
    }


    public function addWaterMarkToPhoto($photoDir = null)
    {
        $dir = (string)(public_path() . '/upload//' . $photoDir);
        $file_display = array('jpg', 'jpeg', 'png', 'gif');
        $watermark = (string)(public_path() . '/image/watermark.png');

        if (file_exists($dir) == true)
        {
            $dir_contents = scandir($dir);
            foreach ($dir_contents as $file)
            {
                $file_type = explode('.', $file);
                $file_extension = strtolower(end($file_type));

                if ($file !== '.' && $file !== '..' && in_array($file_extension, $file_display) == true)
                {
                    // open an image file
                    $img = Image::make($dir . '/' . $file);
                    // now you are able to resize the instance
                    //$img->resize(320, 240);

                    // and insert a watermark for example
                    $img->insert($watermark);

                    // finally we save the image as a new file
                    $img->save($dir . '/' . $file);
                }
            }
        }

        return;

    }


    public static function loadPropertyImages($photoDir = null)
    {

        $dir = (string)(public_path() . '/upload//' . $photoDir);

        $file_display = array('jpg', 'jpeg', 'png', 'gif');
        $i = 0;
        if (file_exists($dir) == false)
        {
            $photo = 'no_photo';
        } else
        {
            $photo = [];
            $dir_contents = scandir($dir);
            foreach ($dir_contents as $file)
            {
                $file_type = explode('.', $file);
                $file_extension = strtolower(end($file_type));

                if ($file !== '.' && $file !== '..' && in_array($file_extension, $file_display) == true)
                {

                    $photo[$i] = (string)($file);
                    $i = $i + 1;
                }
            }
        }

        return $photo;
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


    public function countPageView($property_id)
    {

        $stat = PropertyStat::firstOrNew(array('property_id' => $property_id));
        $stat->property_id = $property_id;
        $stat->view += 1;
        $stat->save();

        return 'ok';

    }


}
