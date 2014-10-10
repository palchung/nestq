<?php

use Illuminate\Database\Migrations\Migration;

class CreateSettingRegionTable extends Migration {

        public function up() {

                Schema::dropIfExists("setting_region");

                Schema::create("setting_region", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->integer("setting_id")->unsigned();
                        $table->integer("region_id")->unsigned();
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");

                        $table->foreign('setting_id')->references('id')->on('setting')->onDelete('cascade');
                        $table->foreign('region_id')->references('id')->on('region')->onDelete('cascade');
                });
        }

        public function down() {
                Schema::dropIfExists("setting_region");
        }

}
