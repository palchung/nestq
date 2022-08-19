<?php

use Illuminate\Database\Migrations\Migration;

class CreateDocumentationTable extends Migration {

    public function up() {
        Schema::dropIfExists("documentation");
        Schema::create("documentation", function($table) {
            $table->engine = "MyISAM";

            $table->increments("id");
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
            $table->integer('sub_category_id');
            $table->string('title', 100);
            $table->longText('content');
        });
    }

    public function down() {
        Schema::dropIfExists("documentation");
    }

}
