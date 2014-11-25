<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogCodeTable extends Migration {

	public function up() {
        Schema::dropIfExists("logcode");
        Schema::create("logcode", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->string('name', 255);

        });
    }

    public function down() {
        Schema::dropIfExists("logcode");
    }

}
