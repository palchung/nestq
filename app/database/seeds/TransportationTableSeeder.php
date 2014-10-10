<?php

class TransportationTableSeeder extends DatabaseSeeder {

        public function run() {
                $faker = $this->getFaker();
                for ($i = 0; $i < 10; $i++) {
                        $name = ucwords($faker->word);
                       
                        Transportation::create([
                            "name" => $name,
                            "active" => 1
                            
                        ]);
                }
        }

}
