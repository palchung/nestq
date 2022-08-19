<?php

class TerritoryTableSeeder extends DatabaseSeeder {

        public function run() {
                
                $faker = $this->getFaker();
                
                for ($i = 0; $i < 5; $i++) {
                        $name = $faker->word;
                       
                        Territory::create([
                            "name" => $name,
                            "active" => 1
                        ]);
                }
        }

}
