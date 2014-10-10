<?php

class PropertyTableSeeder extends DatabaseSeeder {

        public function run() {

                $faker = $this->getFaker();

                $accounts = Account::all();
                $categories = Category::all();
                $regions = Region::all();

                foreach ($accounts as $account) {

                        for ($i = 0; $i < rand(1, 10); $i++) {

                                $ramdom = rand(1, 9);

                                $owner_id = $account->id;
                                $responsible_id = $account->id;
                                $name = ucwords($faker->word);
                                $deal = 0;
                                $structuresize = rand(300, 900);
                                $actualsize = (int) ($structuresize * 0.7);
                                $price = $faker->randomFloat(2, 5, 100);
                                $rentprice = $faker->randomFloat(2, 5, 100);
                                $soldorrent = rand(0, 1);
                                $photo = null;
                                $geolocation = '22.366, 114.125';
                                $category_id = $categories[$ramdom]->id;
                                $region_id = $regions[$ramdom]->id;
                                $nosroom = rand(0, 3);
                                $noslivingroom = rand(0, 2);
                                $publish = 1;
                                $floor = rand(0, 30);
                                $room = rand(0, 30);
                                $block = ucwords($faker->word);
                                $address = ucwords($faker->word);



                                Property::create([
                                    "owner_id" => $owner_id,
                                    "responsible_id" => $responsible_id,
                                    "name" => $name,
                                    "deal" => $deal,
                                    "structuresize" => $structuresize,
                                    "actualsize" => $actualsize,
                                    "price" => $price,
                                    "rentprice" => $rentprice,
                                    "soldorrent" => $soldorrent,
                                    "photo" => $photo,
                                    "geolocation" => $geolocation,
                                    "category_id" => $category_id,
                                    "region_id" => $region_id,
                                    "nosroom" => $nosroom,
                                    "noslivingroom" => $noslivingroom,
                                    "publish" => $publish,
                                    "floor" => $floor,
                                    "room" => $room,
                                    "block" => $block,
                                    "address" => $address
                                ]);
                        }
                }
        }

}
