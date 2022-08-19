<?php

use Illuminate\Database\Migrations\Migration;

class CreateConversationAccountTable extends Migration {

        public function up() {

                Schema::dropIfExists("conversation_account");

                Schema::create("conversation_account", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->integer("conversation_id")->unsigned();
                        $table->integer("account_id")->unsigned();
                        $table->smallInteger("unread");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");

                        $table->foreign('conversation_id')->references('id')->on('conversation')->onDelete('cascade');
                        $table->foreign('account_id')->references('id')->on('account')->onDelete('cascade');
                });
        }

        public function down() {
                Schema::dropIfExists("conversation_account");
        }

}
