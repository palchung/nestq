<?php

use Illuminate\Database\Migrations\Migration;

class CreatePricingTable extends Migration {

        public function up() {
                Schema::dropIfExists("pricing");
                Schema::create("pricing", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->string('scheme', 100);
                        $table->decimal('multi', 5, 2);
                        $table->smallInteger('period');
                        $table->smallInteger('active');
                });
        }

        public function down() {
                Schema::dropIfExists("pricing");
        }

}
