<?php

class PropertyTransportationTableSeeder extends DatabaseSeeder {

    public function run() {

        $faker = $this->getFaker();

        $afters = [];
        $properties = Property::all();
        $transportations = Transportation::all();
        $ok = 'ok';

        foreach ($properties as $property) {

            $property_id = $property->id;

            
            for ($i = 0; $i < rand(0, 5); $i++) {

                $ramdom = rand(1, 9);
                
                if ($i != 0){
                foreach ($afters as $after) {

                    if ($ramdom == $after) {
                        $ok = "not_ok";
                    }
                }
                }

                if ($ok != "not_ok") {
                    $transportation_id = $transportations[$ramdom]->id;

                    PropertyTransportation::create([
                        "property_id" => $property_id,
                        "transportation_id" => $transportation_id
                    ]);
                }
                $ok = "ok";
                $afters[$i] = $ramdom;
            }
        }
    }

}
