<?php

class RegionTableSeeder extends DatabaseSeeder {

        public function run() {
                $faker = $this->getFaker();
                $territories = Territory::all();
                foreach ($territories as $territory) {
                        for ($i = 0; $i < rand(-1, 10); $i++) {
                                $name = $faker->word;
                                Region::create([
                                    "name" => $name,
                                    "territory_id" => $territory->id,
                                    "active" => 1
                                ]);
                        }
                }
        }

}
