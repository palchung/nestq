<?php

class FacilityTableSeeder extends DatabaseSeeder {

        public function run() {
                $faker = $this->getFaker();
                for ($i = 0; $i < 10; $i++) {
                        $name = ucwords($faker->word);
                       
                        Facility::create([
                            "name" => $name,
                            "active" => 1
                            
                        ]);
                }
        }

}
