<?php

use Illuminate\Database\Migrations\Migration;

class CreatePropertyRegionTable extends Migration {

        public function up() {
                Schema::dropIfExists("region");
                Schema::create("region", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->string('name', 100);
                        $table->smallInteger('active');
                        $table->integer('territory_id');
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                });
        }

        public function down() {
                Schema::dropIfExists("region");
        }

}
