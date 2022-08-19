<?php

class ConversationAccountTableSeeder extends DatabaseSeeder {

        public function run() {


                $accounts = Account::all();
                $conversations = Conversation::all();
                $afters = [];
                $ok = 'ok';

                foreach ($accounts as $account) {

                        $account_id = $account->id;

                        for ($i = 0; $i < rand(0, 10); $i++) {

                                $ramdom = rand(1, 1499);

                                if ($i != 0) {
                                        foreach ($afters as $after) {

                                                if ($ramdom == $after) {
                                                        $ok = "not_ok";
                                                }
                                        }
                                }



                                if ($ok != "not_ok") {
                                        $conversation_id = $conversations[$ramdom]->id;

                                        ConversationAccount::create([
                                            "conversation_id" => $conversation_id,
                                            "account_id" => $account_id
                                        ]);
                                }

                                $ok = "ok";
                                $afters[$i] = $ramdom;
                        }
                }
        }

}
