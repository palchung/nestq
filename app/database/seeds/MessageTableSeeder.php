<?php

class MessageTableSeeder extends DatabaseSeeder {

        public function run() {

                $faker = $this->getFaker();

                $conversationsaccounts = ConversationAccount::all();

                foreach ($conversationsaccounts as $conversationsaccount) {

                        $conversation_id = $conversationsaccount->conversation_id;
                        $sender_id = $conversationsaccount->account_id;
                        $message = $faker->text(100);

                        Message::create([
                            "conversation_id" => $conversation_id,
                            "sender_id" => $sender_id,
                            "message" => $message
                        ]);
                }
        }

}
