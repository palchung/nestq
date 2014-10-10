<?php

use Illuminate\Database\Migrations\Migration;

class CreatePropertyFacilityTable extends Migration {

        public function up() {

                Schema::dropIfExists("property_facility");

                Schema::create("property_facility", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->integer("property_id")->unsigned();
                        $table->integer("facility_id")->unsigned();
                                                $table->dateTime("created_at");
                        $table->dateTime("updated_at");

                        $table->foreign('property_id')->references('id')->on('property')->onDelete('cascade');
                        $table->foreign('facility_id')->references('id')->on('facility')->onDelete('cascade');
                });
        }

        public function down() {
                Schema::dropIfExists("property_facility");
        }

}
