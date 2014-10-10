<?php

use Illuminate\Database\Migrations\Migration;

class CreateConversationTable extends Migration {

        public function up() {

                Schema::create("conversation", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->smallInteger('property_id');
                });
        }

        public function down() {
                Schema::dropIfExists("conversation");
        }

}
