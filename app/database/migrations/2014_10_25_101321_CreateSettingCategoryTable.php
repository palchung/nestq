<?php

use Illuminate\Database\Migrations\Migration;

class CreateSettingCategoryTable extends Migration {

    public function up() {

        Schema::dropIfExists("setting_category");

        Schema::create("setting_category", function($table) {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->integer("setting_id")->unsigned();
            $table->integer("category_id")->unsigned();
            $table->dateTime("created_at");
            $table->dateTime("updated_at");

            $table->foreign('setting_id')->references('id')->on('setting')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists("setting_category");
    }

}
