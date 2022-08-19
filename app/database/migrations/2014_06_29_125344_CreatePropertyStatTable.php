<?php

use Illuminate\Database\Migrations\Migration;

class CreatePropertyStatTable extends Migration {

    public function up() {
        Schema::dropIfExists("propertystat");
        Schema::create("propertystat", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
            $table->integer('property_id');
            $table->integer('view')->default(0);
            $table->integer('conversation')->default(0);
            $table->integer('activepush')->default(0);
            $table->integer('activemail')->default(0);
        });
    }

    public function down() {
        Schema::dropIfExists("propertystat");
    }

}
