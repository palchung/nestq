<?php

class ServiceTableSeeder extends DatabaseSeeder {

        public function run() {

                $properties = Property::all();

                foreach ($properties as $property) {
                        Serivce::create([
                            "property_id" => $property->id,
                            "activepush" => 1 //  stand for activrated.
                                
                        ]);
                }
        }

}
