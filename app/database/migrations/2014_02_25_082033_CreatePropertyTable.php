<?php

use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration {

        public function up() {
                
                Schema::create("property", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->integer('owner_id');
                        $table->integer('responsible_id');
                        $table->string('name', 100);
                        $table->boolean('deal', 64)->nullable();
                        $table->integer('structuresize');
                        $table->integer('actualsize');
                        $table->decimal('price', 5, 2);
                        $table->decimal('rentprice', 5, 2);
                        $table->smallInteger('soldorrent');
                        $table->mediumText('photo')->nullable();
                        $table->string('geolocation');
                        $table->smallInteger('category_id');
                        $table->smallInteger('region_id');
                        $table->smallInteger('nosroom');
                        $table->smallInteger('noslivingroom');
                        $table->smallInteger('publish');
                        $table->string('address', 150);
                        $table->integer('floor');
                        $table->string('room',20);
                        $table->string('block',20);

                });
        }

        public function down() {
                Schema::dropIfExists("property");
        }

}
