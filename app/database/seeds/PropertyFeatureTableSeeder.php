<?php

class PropertyFeatureTableSeeder extends DatabaseSeeder {

    public function run() {

        $faker = $this->getFaker();

        $afters = [];
        $properties = Property::all();
        $features = Feature::all();
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
                    $feature_id = $features[$ramdom]->id;

                    PropertyFeature::create([
                        "property_id" => $property_id,
                        "feature_id" => $feature_id
                    ]);
                }
                $ok = "ok";
                $afters[$i] = $ramdom;
            }
        }
    }

}
