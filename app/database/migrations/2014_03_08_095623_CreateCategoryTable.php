<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration {

    public function up() {
        Schema::dropIfExists("category");
        Schema::create("category", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->string('name', 100);
            $table->smallInteger('active');
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
        });
    }

    public function down() {
        Schema::dropIfExists("category");
    }

}
