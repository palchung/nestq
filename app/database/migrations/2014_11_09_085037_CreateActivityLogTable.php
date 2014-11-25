<?php

use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration {

        public function up() {
                Schema::dropIfExists("activitylog");
                Schema::create("activitylog", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->integer('property_id');
                        $table->integer('account_id');
                        $table->integer('logcode_id');

                });
        }

        public function down() {
                Schema::dropIfExists("activitylog");
        }

}
