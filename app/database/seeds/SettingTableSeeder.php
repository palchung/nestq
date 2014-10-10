<?php

class SettingTableSeeder extends DatabaseSeeder {

        public function run() {


                $accounts = Account::all();

                foreach ($accounts as $account) {

                        
                        if($account->identity == 0){
                        
                        Setting::create([
                            "account_id" => $account->id,
                            "agent_request" => 1, // 1 stand for yes
                            "promotion_email" => 1,
                            "disclose_contact" => 0, //
                            "source" => 2
                        ]);
                        
                        
                        }
                        
                        
                        
                }
        }

}
