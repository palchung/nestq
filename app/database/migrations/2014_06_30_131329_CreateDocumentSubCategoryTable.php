<?php

use Illuminate\Database\Migrations\Migration;

class CreateDocumentSubCategoryTable extends Migration {

    public function up() {
        Schema::dropIfExists("documentsubcategory");
        Schema::create("documentsubcategory", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
            $table->integer('category_id');
            $table->string('sub_category', 100);
            $table->smallInteger('active');
        });
    }

    public function down() {
        Schema::dropIfExists("documentsubcategory");
    }

}
