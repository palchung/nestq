<?php

use Illuminate\Database\Migrations\Migration;

class CreateFeatureTable extends Migration {

        public function up() {

                Schema::dropIfExists("feature");
                Schema::create("feature", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->string('name', 100);
                        $table->smallInteger('active');
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                });
        }

        public function down() {
                Schema::dropIfExists("feature");
        }

}
