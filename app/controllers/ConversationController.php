<?php

use Repository\ConversationRepository;
use Repository\PropertyRepository;
use Repository\AccountRepository;

class ConversationController extends BaseController {

    protected $layout = "layout.main";
    protected $conversation;

    public function __construct(ConversationRepository $conversation, PropertyRepository $property)
    {
        //$this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth', array('only' => array('getAdd')));
        $this->conversation = $conversation;
        $this->property = $property;
    }

    public function postProperty()
    {

        $propertyId = Input::get('propertyId');
        $property = PropertyRepository::lookUpPropertyByID($propertyId);

        $validator = Validator::make(Input::all(), Conversation::$messageRules);
        if ($validator->passes())
        {
            $identity = AccountRepository::checkIdentity();
            $conversationId = $this->conversation->saveConversation();
            $message = $this->conversation->loadMessageByConversationId($conversationId);


            return Redirect::action('PropertyController@getPropertyDetail', array($propertyId));


//                        $this->layout->content = View::make('property.detail')
//                                ->with('properties', $property)
//                                ->with('identity', $identity)
//                                ->with('messages', $message);
        } else
        {
            Session::flash('flash_message', 'The following errors occurred');

            return Redirect::to('property/detail')
                ->with('properties', $property)
                ->withErrors($validator)->withInput();
        }
    }

    public function postReplylink()
    {


        $attr = $this->property->loadPropertyData(Input::get('propertyId'));
        $features = $this->property->loadFeatureList();
        $transportations = $this->property->loadTransportationList();
        $facilities = $this->property->loadFacilityList();
        $message = $this->conversation->loadMessageByConversationId(Input::get('conversationId'));
        $property = PropertyRepository::lookUpPropertyByID(Input::get('propertyId'));
        $photo = PropertyRepository::loadPropertyImages($property[0]->property_photo);

        $conversation_id = Input::get('conversationId');

        $this->layout->content = View::make('conversation.reply')
            ->with('attr', $attr)
            ->with('features', $features)
            ->with('transportations', $transportations)
            ->with('facilities', $facilities)
            ->with('messages', $message)
            ->with('property', $property[0])
            ->with('photos', $photo)
            ->with('conversation_id', $conversation_id);
    }

    public function saveMessage()
    {

//        $validator = Validator::make(Input::all(), Conversation::$messageRules);
//        if ($validator->passes())
//        {

            $conversation_id = $this->conversation->saveConversation(Input::get('conversationId'));
//            $newMessage = Input::get('message');
            $newMessage = $this->conversation->loadMessageInDatabase($conversation_id);

            return Response::json(array('response' => $newMessage));
//        } else
//        {
//            return Response::json(array('response' => false));
//        }

    }

    public function loadConversation()
    {

        $conversations = $this->conversation->loadConversationByPropertyId(Input::get('propertyId'));

        return Response::json(array('response' => $conversations));


    }


    public function loadMessage()
    {

        $messages = $this->conversation->loadMessengerMessageByConversationId(Input::get('conversationId'));

        return Response::json(array('response' => $messages));

    }


    public function postReply()
    {

        $validator = Validator::make(Input::all(), Conversation::$messageRules);
        if ($validator->passes())
        {

            $propertyId = Input::get('propertyId');
            $conversationId = $this->conversation->saveConversation(Input::get('conversationId'));
            $message = $this->conversation->loadMessageByConversationId($conversationId);

            $attr = $this->property->loadPropertyData(Input::get('propertyId'));
            $features = $this->property->loadFeatureList();
            $transportations = $this->property->loadTransportationList();
            $facilities = $this->property->loadFacilityList();
            $message = $this->conversation->loadMessageByConversationId(Input::get('conversationId'));
            $property = PropertyRepository::lookUpPropertyByID(Input::get('propertyId'));
            $photo = PropertyRepository::loadPropertyImages($property[0]->property_photo);

            $conversation_id = Input::get('conversationId');

            $this->layout->content = View::make('conversation.reply')
                ->with('attr', $attr)
                ->with('features', $features)
                ->with('transportations', $transportations)
                ->with('facilities', $facilities)
                ->with('messages', $message)
                ->with('property', $property[0])
                ->with('photos', $photo)
                ->with('conversation_id', $conversation_id);


        } else
        {
            $this->layout->content = View::make('conversation.reply')
                ->with('flash_message', 'The following errors occurred')
                ->withErrors($validator)->withInput();
        }
    }

    public function getRealtimechat()
    {
        $this->layout->content = View::make('conversation.realtimechat');
    }

}
