<?php

use Illuminate\Database\Migrations\Migration;

class CreatePropertyFeatureTable extends Migration {

    public function up() {

        Schema::dropIfExists("property_feature");

        Schema::create("property_feature", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->integer("property_id")->unsigned();
            $table->integer("feature_id")->unsigned();
            $table->dateTime("created_at");
            $table->dateTime("updated_at");

            $table->foreign('property_id')->references('id')->on('property')->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('feature')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists("property_feature");
    }

}
