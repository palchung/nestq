<?php

use Repository\PropertyRepository;
use Repository\ConversationRepository;
use Repository\AccountRepository;

class PropertyController extends BaseController {

    protected $layout = "layout.main";
    protected $property;

    public function __construct(PropertyRepository $property, AccountRepository $account)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getAdd')));
        $this->property = $property;
        $this->account = $account;
    }

    public function getAddproperty()
    {

        $identity = $this->property->checkIdentity();
        $checkPublishLimit = $this->property->checkPublishLimit($identity);

        if ($checkPublishLimit == 'ok')
        {

            session_start();
            $_SESSION['photofolder'] = sha1(time());

            $feature = $this->property->loadFeatureList();
            $transportation = $this->property->loadTransportationList();
            $facilities = $this->property->loadFacilityList();
            $categoryList = $this->property->loadCategoryList();
            $regionList = $this->property->loadRegionList();

            $data = [
            'features'        => $feature,
            'transportations' => $transportation,
            'facilities'      => $facilities,
            'categoryList'    => $categoryList,
            'regionList'      => $regionList
            ];
            $this->layout->content = View::make('property.create', compact('data'));
        } else
        {
            Flash::error('您以超出發佈限額');
            $this->layout->content = View::make('property.exceed');
        }
    }

    public function postEdit()
    {
        Session::forget('flash_message');


        session_start();
        $_SESSION['photofolder'] = Input::get('directory');

        $property = $this->property->loadPropertyData(Input::get('propertyId'));
        $features = $this->property->loadFeatureList();
        $transportations = $this->property->loadTransportationList();
        $facilities = $this->property->loadFacilityList();
        $categoryList = $this->property->loadCategoryList();
        $regionList = $this->property->loadRegionList();
        $this->layout->content = View::make('property.create')
        ->with('features', $features)
        ->with('transportations', $transportations)
        ->with('facilities', $facilities)
        ->with('property', $property)
        ->with('categoryList', $categoryList)
        ->with('regionList', $regionList);


    }

    public function postPublish()
    {

        $identity = $this->property->checkIdentity();
        $checkPublishLimit = $this->property->checkPublishLimit($identity);

        if ($checkPublishLimit == 'ok')
        {
            $property_id = Input::get('propertyId');
            $publish = $this->property->publishProperty($property_id);
            if ($publish == 'ok')
            {
                Flash::success('成功為您發佈了物業資訊');
                return Redirect::to('account/dashboard/property');
            }
        } else
        {
            $this->layout->content = View::make('property.exceed');
        }
    }

    public function postLaydown(){

        $property_id = Input::get('propertyId');
        $this->property->laydownProperty($property_id);

        Flash::warning('停止發佈了物業資訊');
        return Redirect::to('account/dashboard/property');

    }





    public function postCreate()
    {
        // trim all input
        // Input::merge(array_map('trim', Input::all()));

        $validator = Validator::make(Input::all(), Property::$PropertyRules);
        if ($validator->passes())
        {

            $property_id = Input::get('propertyId');
            // if $property != null then it mean editing
            $createProperty = $this->property->createProperty($property_id);
            Flash::success('物業資訊以被記錄了，您希望現在就發佈它嗎？');

            // add watermark
            $this->property->addWaterMarkToPhoto($createProperty->photo);

            $attr = $this->property->loadPropertyData($createProperty->id);
            $features = $this->property->loadFeatureList();
            $transportations = $this->property->loadTransportationList();
            $facilities = $this->property->loadFacilityList();
            $property = $this->property->lookUpPropertyByID($createProperty->id);

            // load image
            if ($createProperty->photo)
            {
                $photo = $this->property->loadPropertyImages($createProperty->photo);
            } else
            {
                $photo = 'no_photo';
            }
            $this->layout->content = View::make('property.preview')
            ->with('attr', $attr)
            ->with('features', $features)
            ->with('transportations', $transportations)
            ->with('facilities', $facilities)
            ->with('photos', $photo)
            ->with('properties', $property);
        } else
        {
            Flash::error('以下錯誤發生了');
            return Redirect::to('property/addproperty')->withErrors($validator)->withInput();
        }
    }

    public function getPropertyDetail($property_id)
    {

        $attr = $this->property->loadPropertyData($property_id);
        $features = $this->property->loadFeatureList();
        $transportations = $this->property->loadTransportationList();
        $facilities = $this->property->loadFacilityList();


        $property = $this->property->lookUpPropertyByID($property_id);

        $nosOfProperty = $this->account->loadNosOfResponsibleProperty($property[0]->account_id);

        $property_responsible = $property[0]->property_responsible_id;
        $property_owner = $property[0]->property_owner_id;
        $property_resonsible_identity = $property[0]->account_identity;

        if ($property_resonsible_identity == 1)
        { // a agent
            $property_responible_allow_request = true;
        } else
        { // a user
            $allow_request = AccountRepository::checkRequestAllowance($property_id);
            if ($allow_request == 'ok')
            {
                $property_responible_allow_request = true;
            } else
            {
                $property_responible_allow_request = false;
            }
        }


        if (Auth::check())
        {


            if (Auth::user()->identity == 0)
            {
                $identity = 'user';
            } elseif (Auth::user()->identity == 1)
            {
                $identity = 'agent';
            }

            // logic for message showing
            if ($property_responsible == Auth::user()->id)
            {
                $responsible = 'yes';
                $message = ConversationRepository::loadMessageByProperty($property_id, $responsible);
                $showMessage = 'yes';
            } else
            {

                $hasConversation = ConversationRepository::checkHasConversation($property_id);
                if ($hasConversation == 'yes')
                {
                    $showMessage = 'yes';
                    $responsible = 'no';
                    $message = ConversationRepository::loadMessageByProperty($property_id, $responsible);
                } else
                {
                    $showMessage = 'no';
                    $message = null;
                }
            }


            // logic for request showing


            // $user_allow_request = $this->property->checkUserAllowRequest($property_id);

            if (
                ($property_responsible != Auth::user()->id) //
                && ($property_responsible == $property_owner) //
                && ($property_resonsible_identity != 1) //
                && ($property_responible_allow_request == true)
                // && ($user_allow_request)
                )
            {
                $identity = AccountRepository::checkIdentity();
                $repeat_request = $this->property->checkRepeatRequest($property_id);
                if (($identity == 'agent') && $repeat_request == 'no')
                {
                    $service = Config::get('nestq.REQUISITION_ID');
                    $paid = Service::checkServicePayment($service);

                    if ($paid == 'paid')
                    {
                        $template = AccountRepository::loadTemplate();
                        $showRequest = 'yes';
                    } else
                    {
                        $template = '';
                        $showRequest = 'no';
                    }
                } elseif (($identity == 'agent') && $repeat_request == 'yes')
                {
                    Session::flash('flash_message', 'Request sent');
                    $showRequest = 'no';
                    $template = '';
                } else
                {
                    $showRequest = 'no';
                    $template = '';
                }
            } else
            {
                $showRequest = 'no';
                $template = '';
            }
        } else
        {
            $identity = 'someone';
            $showMessage = 'no';
            $template = '';
            $showRequest = 'no';
            $message = null;
        }

        // load image
        $photo = $this->property->loadPropertyImages($property[0]->property_photo);

        if (sizeof($photo) == 0)
        {
            $photo = 'no_photo';
        }

        // count page view
        $countView = $this->property->countPageView($property_id);
        if ($countView != 'ok')
        {
            throw new Exception("Cant count page view", 1);
        }

        $discloseUserContact = $this->account->checkContactPerssion($property[0]->account_identity, $property[0]->account_id);


        //render front end
        $this->layout->content = View::make('property.detail')
        ->with('attr', $attr)
        ->with('features', $features)
        ->with('transportations', $transportations)
        ->with('facilities', $facilities)
        ->with('photos', $photo)
        ->with('identity', $identity)
        ->with('property', $property[0])
        ->with('discloseUserContact', $discloseUserContact)
        ->with('nosOfProperty', $nosOfProperty)
        ->with('messages', $message)
        ->with('showRequest', $showRequest)
        ->with('showMessage', $showMessage)
        ->with('template', $template);
    }

    public function postRequisition()
    {
        $propertyId = Input::get('propertyId');

        $validator = Validator::make(Input::all(), Property::$RequisitionRules);
        if ($validator->passes())
        {

//            $propertyId = Input::get('propertyId');
            $check = $this->property->checkRequest();
            $service = Config::get('nestq.REQUISITION_ID');
            $paid = Service::checkServicePayment($service);
            if ($check == 'ok' && $paid == 'paid')
            {
                $request = $this->property->saveRequest();
                Session::flash('flash_message', 'request sent');

                return Redirect::action('PropertyController@getPropertyDetail', array($propertyId));
            } elseif ($check == 'repeat' && $paid == 'paid')
            {
                Session::flash('flash_message', 'Repeat request');

                return Redirect::action('PropertyController@getPropertyDetail', array($propertyId));
            } elseif ($paid == 'not_paid')
            {
                $this->layout->content = View::make('payment.pricepage');
            } else
            {
                $this->layout->content = View::make('system.error');
            }

        } else
        {
            Flash::error('輸入的請求超過了字數限制');

            return Redirect::action('PropertyController@getPropertyDetail', array($propertyId));
        }


    }

    public function postCanelRequest($property_id){

        $this->property->updatePropertyResponsible($property_id);
        $this->property->updateActivityLogForRequestExpire($property_id);

        Flash::success('以為您取回代理權');
        return Redirect::to('account/dashboard/property');

    }



    public function getRequestByProperty($property_id)
    {

        $auth = $this->property->checkOwnership($property_id);

        if ($auth == 'ok')
        {
            $request = $this->property->loadRequestByPropertyId($property_id);
            $property = $this->property->lookUpPropertyByID($property_id);
            $this->layout->content = View::make('property.request')
            ->with('property', $property[0])
            ->with('requests', $request);
        } else
        {
            $this->layout->content = View::make('system.error');
        }
    }

    public function postAgreement()
    {

        $agreement = $this->property->loadAgreementByRequestId();

        $this->layout->content = View::make('property.agreement')
        ->with('agreement', $agreement[0]);
    }

    public function postAccept()
    {


        $request_id = Input::get('requestId');
        $agent_id = Input::get('agentId');
        $property_id = Input::get('propertyId');

        $this->property->handOverPropertyToAgent($request_id, $agent_id, $property_id);
        // log code = 1 stand for hand over property
        $this->property->informAgentRequestSuccess($agent_id, $property_id, Config::get('nestq.REQUEST_SUCCESS'));

        Flash::success('您的物業資訊成功轉交代理人');


        // return Redirect::action('AccountController@getDashboard', array('dashboard_content'=>'property'));
        return Redirect::to('account/dashboard/property');
    }

}
