<?php

class messengerController extends BaseController {

    public function Messenger()
    {

//        header("Content-Type: text/event-stream\n\n");
//        header('Cache-Control: no-cache');

        $properties = $this->loadContactOnMessenger();
        $this->pushMessage($properties);
    }


    public function Messages($conversationId)
    {
        $message = $this->loadMessageInDatabase($conversationId);
        $this->pushMessage($message);
    }

    public function loadMessageInDatabase($conversation_id)
    {
        $messages = DB::table('message')
        ->join('account', 'account.id', '=', 'message.sender_id')
        ->select([
            'message.conversation_id as message_conversation_id',
            'message.message as message',
            'message.id as message_id',
            'message.created_at as message_created_at',
            'account.firstname as account_firstname',
            'account.lastname as account_lastname',
            'account.id as account_id',
            'account.profile_pic as account_profile_pic'
            ])
        ->where('message.conversation_id', '=', $conversation_id)
//            ->where('account.id','<>',Auth::user()->id)
        ->orderBy('message.created_at', 'DESC')
        ->distinct()
        ->first();

        if ($messages->account_id == Auth::user()->id){
            $messages = 'no_new_message';
        }

        return $messages;

    }


    public function pushMessage($msg)
    {

        header("Content-Type: text/event-stream\n\n");
        header('Cache-Control: no-cache');

        echo "retry: " . Config::get('nestq.ACTIVE_PUSH_INTERVAL') . "\n\n";
        echo "data:" . json_encode($msg) . "\n\n";
//        echo "data:" . $msg . PHP_EOL;
        echo PHP_EOL;
        ob_flush();
        flush();
    }


    public function loadConversation($propertyId)
    {

        header("Content-Type: text/event-stream\n\n");
        header('Cache-Control: no-cache');

        $conversation = DB::table('conversation')
        ->join('conversation_account', 'conversation_account.conversation_id', '=', 'conversation.id')
        ->select([
            'conversation.property_id as property_id',
            'conversation.id as conversation_id',
            ])
        ->where('conversation_account.account_id', '=', Auth::user()->id)
        ->where('conversation.property_id', '=', $propertyId)
        ->get();

        $this->pushMessage($conversation);
    }

    public function loadMessage($conversationId)
    {
        header("Content-Type: text/event-stream\n\n");
        header('Cache-Control: no-cache');

        $message = $this->loadMessageOnMessenger($conversationId);
        $this->pushMessage($message);
    }

    public function loadMessageOnMessenger($conversationId)
    {
        $messages = DB::table('message')
        ->join('account', 'account.id', '=', 'message.sender_id')
        ->select([
            'message.conversation_id as message_conversation_id',
            'message.message as message',
            'message.created_at as message_created_at',
            'account.firstname as account_firstname',
            'account.lastname as account_lastname'
            ])
        ->where('message.conversation_id', '=', $conversationId)
        ->orderBy('message.created_at')
        ->get();

        return $messages;
    }

    public function loadContactOnMessenger()
    {

        $properties = DB::table('conversation')
        ->join('property', 'property.id', '=', 'conversation.property_id')
        ->join('conversation_account', 'conversation_account.conversation_id', '=', 'conversation.id')
        ->join('region', 'region.id', '=', 'property.region_id')
        ->join('category', 'category.id', '=', 'property.category_id')
        ->select([
            'conversation.id as conversation_id',
            'property.id as property_id',
            'property.name as property_name',
            'property.photo as property_photo',
            'property.price as property_price',
            'property.rentprice as property_rentprice',
            'property.soldorrent as property_soldorrent',
            'region.name as property_region',
            'category.name as property_category',
            ])
        ->where('conversation_account.account_id', '=', Auth::user()->id)
        ->where('property.publish','=', 1)
        ->orderBy('conversation_account.updated_at','desc')
        ->distinct()
        ->get();

// get thumbnail
        foreach ($properties as $property)
        {
            $dir = (string)(public_path() . '/upload//' . $property->property_photo);
            $file_display = array('jpg', 'jpeg', 'png', 'gif');
            $i = 0;
            if (file_exists($dir) == false)
            {
                $thumbnail = 'no_photo';
            } else
            {
                $dir_contents = scandir($dir);
                foreach ($dir_contents as $file)
                {
                    $file_type = explode('.', $file);
                    $file_extension = strtolower(end($file_type));

                    if ($file !== '.' && $file !== '..' && in_array($file_extension, $file_display) == true)
                    {
                        $property->thumbnail = (string)($file);
                    }
                }
            }
        }


        return $properties;
    }

    public function Notification()
    {
        header("Content-Type: text/event-stream\n\n");
        header('Cache-Control: no-cache');
        $nosOfUnread = $this->countUnreadMessages();
        //$unread = 'hi';
        $msg = [
        "unread" => $nosOfUnread
        ];
        $this->pushMessage($msg);
    }

    public function countUnreadMessages()
    {
        $nosOfUnread = DB::table('conversation_account')
        ->where('account_id', '=', Auth::user()->id)
        ->where('unread', '=', 1)
        ->count();

        return $nosOfUnread;
    }

}
