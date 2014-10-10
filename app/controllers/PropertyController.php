<?php

use Repository\PropertyRepository;
use Repository\ConversationRepository;
use Repository\AccountRepository;

class PropertyController extends BaseController
{

    protected $layout = "layout.main";
    protected $property;

    public function __construct(PropertyRepository $property)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getAdd')));
        $this->property = $property;
    }

    public function getAddproperty()
    {

        $identity = $this->property->checkIdentity();
        $checkPublishLimit = $this->property->checkPublishLimit($identity);

        if ($checkPublishLimit == 'ok') {

            session_start();
            $_SESSION['photofolder'] = sha1(time());

            $feature = $this->property->loadFeatureList();
            $transportation = $this->property->loadTransportationList();
            $facilities = $this->property->loadFacilityList();
            $categoryList = $this->property->loadCategoryList();
            $regionList = $this->property->loadRegionList();

            $data = [
                'features' => $feature,
                'transportations' => $transportation,
                'facilities' => $facilities,
                'categoryList' => $categoryList,
                'regionList' => $regionList
            ];
            $this->layout->content = View::make('property.create', compact('data'));
        } else {
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

        if ($checkPublishLimit == 'ok') {

            $publish = $this->property->publishProperty();
            if ($publish == 'ok') {
                Session::flash('flash_message', 'you published a new property.');

                return Redirect::to('account/dashboard/property');
            }
        } else {
            $this->layout->content = View::make('property.exceed');
        }
    }

    public function postCreate()
    {

        $validator = Validator::make(Input::all(), Property::$propertyRules);
        if ($validator->passes()) {

            $property_id = Input::get('propertyId');

            $createProperty = $this->property->createProperty($property_id);
            Session::flash('flash_message', 'You property has created, would you like publish now ?');


            $attr = $this->property->loadPropertyData($createProperty->id);
            $features = $this->property->loadFeatureList();
            $transportations = $this->property->loadTransportationList();
            $facilities = $this->property->loadFacilityList();
            $property = $this->property->lookUpPropertyByID($createProperty->id);
            // load image
            if ($property[0]->property_photo) {
                $photo = $this->property->loadPropertyImages($property[0]->property_photo);
            } else {
                $photo = 'no_photo';
            }
            $this->layout->content = View::make('property.preview')
                ->with('attr', $attr)
                ->with('features', $features)
                ->with('transportations', $transportations)
                ->with('facilities', $facilities)
                ->with('photos', $photo)
                ->with('properties', $property);


        } else {
            return Redirect::to('property/create')
                ->with('flash_message', 'The following errors occurred')
                ->withErrors($validator)->withInput();
        }
    }

    public function getPropertyDetail($property_id)
    {

        $attr = $this->property->loadPropertyData($property_id);
        $features = $this->property->loadFeatureList();
        $transportations = $this->property->loadTransportationList();
        $facilities = $this->property->loadFacilityList();


        $property = $this->property->lookUpPropertyByID($property_id);

        $nosOfProperty = AccountRepository::loadNosOfResponsibleProperty($property[0]->account_id);

        $property_responsible = $property[0]->property_responsible_id;
        $property_owner = $property[0]->property_owner_id;
        $property_resonsible_identity = $property[0]->account_identity;

        if ($property_resonsible_identity == 1) { // a agent
            $property_responible_allow_request = true;
        } else { // a user
            $allow_request = AccountRepository::checkRequestAllowance($property_id);
            if ($allow_request == 'ok') {
                $property_responible_allow_request = true;
            } else {
                $property_responible_allow_request = false;
            }
        }


        if (Auth::check()) {


            if (Auth::user()->identity == 0) {
                $identity = 'user';
            } elseif (Auth::user()->identity == 1) {
                $identity = 'agent';
            }

            // logic for message showing
            if ($property_responsible == Auth::user()->id) {
                $responsible = 'yes';
                $message = ConversationRepository::loadMessageByProperty($property_id, $responsible);
                $showMessage = 'yes';
            } else {

                $hasConversation = ConversationRepository::checkHasConversation($property_id);
                if ($hasConversation == 'yes') {
                    $showMessage = 'yes';
                    $responsible = 'no';
                    $message = ConversationRepository::loadMessageByProperty($property_id, $responsible);
                } else {
                    $showMessage = 'no';
                    $message = null;
                }
            }


            // logic for request showing
            if (
                ($property_responsible != Auth::user()->id) //
                && ($property_responsible == $property_owner) //
                && ($property_resonsible_identity != 1) //
                && ($property_responible_allow_request == true)
            ) {
                $identity = AccountRepository::checkIdentity();
                $repeat_request = $this->property->checkRepeatRequest($property_id);
                if (($identity == 'agent') && $repeat_request == 'no') {


                    $service = Config::get('nestq.REQUISITION_ID');
                    $paid = Service::checkServicePayment($service);

                    if ($paid == 'paid') {
                        $template = AccountRepository::loadTemplate();
                        $showRequest = 'yes';
                    } else {
                        $template = '';
                        $showRequest = 'no';
                    }
                } elseif (($identity == 'agent') && $repeat_request == 'yes') {
                    Session::flash('flash_message', 'Request sent');
                    $showRequest = 'no';
                    $template = '';
                } else {
                    $showRequest = 'no';
                    $template = '';
                }
            } else {
                $showRequest = 'no';
                $template = '';
            }
        } else {
            $identity = 'someone';
            $showMessage = 'no';
            $template = '';
            $showRequest = 'no';
            $message = null;
        }

        // load image
        $photo = $this->property->loadPropertyImages($property[0]->property_photo);

        // count page view
        $countView = $this->property->countPageView($property_id);
        if ($countView != 'ok') {
            throw new Exception("Cant count page view", 1);
        }


        //render front end
        $this->layout->content = View::make('property.detail')
            ->with('attr', $attr)
            ->with('features', $features)
            ->with('transportations', $transportations)
            ->with('facilities', $facilities)
            ->with('photos', $photo)
            ->with('identity', $identity)
            ->with('property', $property[0])
            ->with('nosOfProperty', $nosOfProperty)
            ->with('messages', $message)
            ->with('showRequest', $showRequest)
            ->with('showMessage', $showMessage)
            ->with('template', $template);
    }

    public function postRequisition()
    {

        $propertyId = Input::get('propertyId');
        $check = $this->property->checkRequest();
        $service = Config::get('nestq.REQUISITION_ID');
        $paid = Service::checkServicePayment($service);
        if ($check == 'ok' && $paid == 'paid') {
            $request = $this->property->saveRequest();
            Session::flash('flash_message', 'request sent');

            return Redirect::action('PropertyController@getPropertyDetail', array($propertyId));
        } elseif ($check == 'repeat' && $paid == 'paid') {
            Session::flash('flash_message', 'Repeat request');

            return Redirect::action('PropertyController@getPropertyDetail', array($propertyId));
        } elseif ($paid == 'not_paid') {
            $this->layout->content = View::make('payment.pricepage');
        } else {
            $this->layout->content = View::make('system.error');
        }
    }

    public function getRequestByProperty($property_id)
    {

        $auth = $this->property->checkOwnership($property_id);

        if ($auth == 'ok') {
            $request = $this->property->loadRequestByPropertyId($property_id);
            $property = $this->property->lookUpPropertyByID($property_id);
            $this->layout->content = View::make('property.request')
                ->with('property', $property[0])
                ->with('requests', $request);
        } else {
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

        $accept_agent = $this->property->handOverPropertyToAgent();
        Session::flash('flash_message', 'Your Property has hand over');

        // return Redirect::action('AccountController@getDashboard', array('dashboard_content'=>'property'));
        return Redirect::to('account/dashboard/property');
    }

}
