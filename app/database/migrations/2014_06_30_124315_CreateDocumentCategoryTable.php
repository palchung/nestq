<?php

use Illuminate\Database\Migrations\Migration;

class CreateDocumentCategoryTable extends Migration {

    public function up() {
        Schema::dropIfExists("documentcategory");
        Schema::create("documentcategory", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
            $table->string('category', 100);
            $table->smallInteger('active');
        });
    }

    public function down() {
        Schema::dropIfExists("documentcategory");
    }

}
