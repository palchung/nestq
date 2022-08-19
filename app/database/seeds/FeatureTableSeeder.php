<?php

class FeatureTableSeeder extends DatabaseSeeder {

        public function run() {
                $faker = $this->getFaker();
                for ($i = 0; $i < 10; $i++) {
                        $name = ucwords($faker->word);
                       
                        Feature::create([
                            "name" => $name,
                            "active" => 1
                            
                        ]);
                }
        }

}
