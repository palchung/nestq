<?php

class DatabaseSeeder extends Seeder {

        protected $faker;

        public function getFaker() {
                if (empty($this->faker)) {
                        $this->faker = Faker\Factory::create();
                }
                return $this->faker;
        }

        public function run() {

                Eloquent::unguard();

                $this->call("TerritoryTableSeeder");
                $this->call("RegionTableSeeder");
                $this->call("CategoryTableSeeder");
                $this->call("AccountTableSeeder");
                $this->call("FacilityTableSeeder");
                $this->call("TransportationTableSeeder");
                $this->call("FeatureTableSeeder");
                $this->call("PropertyTableSeeder");
                $this->call("ConversationTableSeeder");
                $this->call("PropertyFacilityTableSeeder");
                $this->call("PropertyTransportationTableSeeder");
                $this->call("PropertyFeatureTableSeeder");
                //$this->call("ConversationAccountTableSeeder");
                //$this->call("MessageTableSeeder");
                $this->call("SettingTableSeeder");
                $this->call("PricepageTableSeeder");
                //$this->call("ActivepushTableSeeder");
                //$this->call("RequestTableSeeder");
        }

}
