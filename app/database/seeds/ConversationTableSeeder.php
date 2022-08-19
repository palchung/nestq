<?php

class ConversationTableSeeder extends DatabaseSeeder {

    public function run() {

        
        $propertis = Property::all();

        foreach ($propertis as $property) {

            
            $property_id = $property->id;
            

 

                Conversation::create([
                    "property_id" => $property_id
                        
                ]);
            
        }
    }

}
