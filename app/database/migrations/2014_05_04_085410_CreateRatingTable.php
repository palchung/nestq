<?php

use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration {

        public function up() {
                Schema::dropIfExists("rating");
                Schema::create("rating", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->smallInteger('user_id');
                        $table->smallInteger('agent_id');
                });
        }

        public function down() {
                Schema::dropIfExists("rating");
        }

}
