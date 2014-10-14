<?php

namespace Repository;

use Account;
use Conversation;
use ConversationAccount;
use Message;
use Property;
use Facility;
use Category;
use Region;
use Territory;
use Hash;
use Input;
use Auth;
use DB;
use PropertyStat;

class ConversationRepository {

    public function saveConversation($conversation_id = null)
    {


        $senderId = Auth::user()->id;
        $propertyId = Input::get('propertyId');
        $new_message = Input::get('message');

        $conversationId = DB::table('conversation')
            ->join('conversation_account', 'conversation.id', '=', 'conversation_account.conversation_id')
            ->select('conversation.id')
            ->where('conversation.property_id', '=', $propertyId)
            ->where('conversation_account.account_id', '=', $senderId)
            ->groupBy('conversation.id')
            ->get();

        // if no conversation before
        if (empty($conversationId) && $conversation_id == null)
        {

            // register a conversation id
            $conversation = new Conversation;
            $conversation->property_id = Input::get('propertyId');
            $conversation->save();

            $recipientId = $this->getRecipientNewConversation($propertyId);

            $sender = new ConversationAccount;
            $sender->conversation_id = $conversation->id;
            $sender->account_id = $senderId;
            $sender->unread = 0; // 0 stand for read
            $sender->save();

            $recipient = new ConversationAccount;
            $recipient->conversation_id = $conversation->id;
            $recipient->account_id = $recipientId;
            $recipient->unread = 1; // 1 stand for unread
            $recipient->save();

            $message = new Message;
            $message->sender_id = $senderId;
            $message->conversation_id = $conversation->id;
            $message->message = $new_message;
            $message->save();

            // update property Stat
            $stat = PropertyStat::firstOrCreate(array('property_id' => $conversation->property_id));
            $stat->conversation = $stat->conversation + 1;
            $stat->save();


            return $conversation->id;

            // if have conversation already
        } else
        {
            if ($conversation_id != null)
            {
                $cid = $conversation_id;
            } else
            {
                $cid = $conversationId[0]->id;
            }

            $recipientId = $this->getRecipientExistingConversation($senderId, $cid);

            $sender = DB::table('conversation_account')
                ->where('conversation_id', $cid)
                ->where('account_id', $senderId, 'AND')
                ->update(array('unread' => 0));

            $recipient = DB::table('conversation_account')
                ->where('conversation_id', $cid)
                ->where('account_id', '=', $recipientId)
                ->update(array('unread' => 1));

            $message = new Message;
            $message->sender_id = $senderId;
            $message->conversation_id = $cid;
            $message->message = $new_message;
            $message->save();

            return $cid;
        }
    }

    public function getRecipientNewConversation($property_id = null)
    {


        $recipient = Property::find($property_id)->responsible_id;

        return $recipient;


//                $recipient = DB::table('property')
//                        ->select(['responsible_id'])
//                        ->where('id', '=', $property_id)
//                        ->get();
//                return $recipient[0];
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
            ->where('account.id', '=', Auth::user()->id)
            ->orderBy('message.created_at', 'DESC')
            ->distinct()
            ->first();

        return $messages;

    }

    public function getRecipientExistingConversation($sender_id = null, $conversation_id = null)
    {

        $recipient = DB::table('conversation_account')
            ->where('conversation_id', '=', $conversation_id)
            ->whereNotIn('account_id', array($sender_id))
            ->get();

        return $recipient[0]->account_id;
    }

    public function loadMessageByConversationId($conversationId)
    {

        $messages = DB::table('message')
            ->join('account', 'message.sender_id', '=', 'account.id')
            ->select(
                'message.id as message_id', 'message.created_at as message_created_at', 'message.sender_id as message_sender_id', 'message.conversation_id as message_conversation_id', 'message.message as message_message', 'account.firstname as account_firstname', 'account.lastname as account_lastname'
            )
            ->where('conversation_id', '=', $conversationId)
            ->groupBy('message.conversation_id')
            ->groupBy('message.id')
            ->get();

        return $messages;
    }

    public static function loadMessageByProperty($property_id, $responsible)
    {

        $messages = DB::table('conversation');
        $messages->join('message', 'conversation.id', '=', 'message.conversation_id');
        $messages->join('account', 'message.sender_id', '=', 'account.id');
        if ($responsible != 'yes')
        {
            $messages->join('conversation_account', 'conversation.id', '=', 'conversation_account.conversation_id');
        }

        $messages->select(
            'message.id as message_id', 'message.created_at as message_created_at', 'message.sender_id as message_sender_id', 'message.conversation_id as message_conversation_id', 'message.message as message_message', 'account.firstname as account_firstname', 'account.lastname as account_lastname'
        );

        if ($responsible != 'yes')
        {


            $y = array(Auth::user()->id, $responsible);
            $messages->whereIn('conversation_account.account_id', $y);
        }
        $messages->where('conversation.property_id', '=', $property_id);

        $messages->groupBy('message.conversation_id');
        $messages->groupBy('message.id');
        $data = $messages->get();

        return $data;
    }

    public static function checkHasConversation($property_id)
    {

        $conversation = DB::table('conversation')
            ->join('conversation_account', 'conversation.id', '=', 'conversation_account.conversation_id')
            ->where('conversation.property_id', '=', $property_id)
            ->where('conversation_account.account_id', '=', Auth::user()->id)
            ->get();
        if (sizeof($conversation) == 0)
        {
            $hasConversation = 'no';
        } else
        {
            $hasConversation = 'yes';
        }

        return $hasConversation;
    }


    public function loadConversationByPropertyId($property_id = null)
    {

        $conversations = DB::table('conversation')
            ->join('property', 'property.id', '=', 'conversation.property_id')
            ->join('conversation_account', 'conversation_account.conversation_id', '=', 'conversation.id')
            ->join('message', 'message.conversation_id', '=', 'conversation_account.conversation_id')
            ->join('account', 'account.id', '=', 'message.sender_id')
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
                'account.firstname as account_firstname',
                'account.lastname as account_lastname',
                'account.profile_pic as account_profile_pic',
            ])
            ->where('conversation_account.account_id', '=', Auth::user()->id)
            ->where('conversation.property_id', '=', $property_id)
            ->orderBy('conversation_account.updated_at')
            ->distinct()
            ->get();

        // get thumbnail
        foreach ($conversations as $conversation)
        {
            $dir = (string)(public_path() . '/upload//' . $conversation->property_photo);
            $file_display = array('jpg', 'jpeg', 'png', 'gif');
            $i = 0;
            if (file_exists($dir) == false)
            {
                $conversation->thumbnail = 'no_photo';
            } else
            {
                $dir_contents = scandir($dir);
                foreach ($dir_contents as $file)
                {
                    $file_type = explode('.', $file);
                    $file_extension = strtolower(end($file_type));

                    if ($file !== '.' && $file !== '..' && in_array($file_extension, $file_display) == true)
                    {
                        $conversation->thumbnail = (string)($file);
                    }
                }
            }
        }

        return $conversations;
    }


    public function loadMessengerMessageByConversationId($conversation_id = null)
    {
        $messages = DB::table('conversation')
            ->join('property', 'property.id', '=', 'conversation.property_id')
            ->join('conversation_account', 'conversation_account.conversation_id', '=', 'conversation.id')
            ->join('message', 'message.conversation_id', '=', 'conversation_account.conversation_id')
            ->join('account', 'account.id', '=', 'message.sender_id')
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
                'message.id as message_id',
                'message.created_at as message_created_at',
                'message.message as message',
                'message.created_at as message_created_at',
                'account.firstname as account_firstname',
                'account.lastname as account_lastname',
                'account.profile_pic as account_profile_pic',
            ])
            ->where('conversation_account.account_id', '=', Auth::user()->id)
            ->where('conversation.id', '=', $conversation_id)
            ->orderBy('conversation_account.updated_at')
            ->distinct()
            ->get();

        return $messages;

    }


}
