<?php

use Illuminate\Database\Migrations\Migration;

class CreatePricepageTable extends Migration {

        public function up() {
                Schema::dropIfExists("pricepage");
                Schema::create("pricepage", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->string('item', 100);
                        $table->decimal('price', 5, 2);
                        $table->smallInteger('package');
                        $table->smallInteger('active');
                });
        }

        public function down() {
                Schema::dropIfExists("pricepage");
        }

}
