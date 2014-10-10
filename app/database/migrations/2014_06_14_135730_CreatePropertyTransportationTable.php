<?php

use Illuminate\Database\Migrations\Migration;

class CreatePropertyTransportationTable extends Migration {

        public function up() {

                Schema::dropIfExists("property_transportation");

                Schema::create("property_transportation", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->integer("property_id")->unsigned();
                        $table->integer("transportation_id")->unsigned();
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");

                        $table->foreign('property_id')->references('id')->on('property')->onDelete('cascade');
                        $table->foreign('transportation_id')->references('id')->on('transportation')->onDelete('cascade');
                });
        }

        public function down() {
                Schema::dropIfExists("property_transportation");
        }

}
