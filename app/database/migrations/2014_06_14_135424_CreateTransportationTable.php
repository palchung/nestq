<?php

use Illuminate\Database\Migrations\Migration;

class CreateTransportationTable extends Migration {

        public function up() {

                Schema::dropIfExists("transportation");
                Schema::create("transportation", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->string('name', 100);
                        $table->smallInteger('active');
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                });
        }

        public function down() {
                Schema::dropIfExists("transportation");
        }

}
