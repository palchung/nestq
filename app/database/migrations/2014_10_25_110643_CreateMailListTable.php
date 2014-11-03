<?php

use Illuminate\Database\Migrations\Migration;

class CreateMailListTable extends Migration {

    public function up() {
        Schema::dropIfExists("maillist");
        Schema::create("maillist", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
            $table->dateTime("deleted_at");
            $table->Integer("account_id");
            $table->smallInteger("status"); // 1 stand for successfully sent to user
            $table->smallInteger("sent"); // 1 stand for have sent to user within a week

        });
    }

    public function down() {
        Schema::dropIfExists("maillist");
    }

}
