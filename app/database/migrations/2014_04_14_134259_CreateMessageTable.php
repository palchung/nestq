<?php

use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration {

        public function up() {

                Schema::create("message", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                                                $table->dateTime("updated_at");
                        $table->smallInteger('conversation_id');
                        $table->smallInteger('sender_id');
                        $table->longText('message');
                });
        }

        public function down() {
                Schema::dropIfExists("message");
        }

}
