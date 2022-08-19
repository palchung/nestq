<?php

class PricepageTableSeeder extends DatabaseSeeder {

        public function run() {
                $faker = $this->getFaker();


                        for ($i = 0; $i < 6; $i++) {
                                $item = ucwords($faker->word);
                                Pricepage::create([
                                    "item" => $item,
                                    "price" => $faker->randomFloat(2, 5, 100),
                                    "package" => 1
                                ]);
                        }
                
        }

}
