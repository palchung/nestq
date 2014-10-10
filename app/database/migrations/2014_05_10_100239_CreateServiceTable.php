<?php

use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration {

        public function up() {
                Schema::dropIfExists("service");
                Schema::create("service", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->smallInteger('account_id');
                        $table->smallInteger('item_id');
                        $table->dateTime('period');
                });
        }

        public function down() {
                Schema::dropIfExists("service");
        }

}
