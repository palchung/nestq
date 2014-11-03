<?php

use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration {

    public function up()
    {
        Schema::dropIfExists("setting");
        Schema::create("setting", function ($table)
        {
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->integer('account_id');
            $table->smallInteger('agent_request');
            $table->smallInteger('promotion_email');
            $table->smallInteger('disclose_contact');


            $table->smallInteger('soldorrent');
            $table->decimal('price', 5, 2)->nullable();
            $table->decimal('rentprice', 5, 2)->nullable();
            $table->integer('actualsize')->nullable();
            $table->smallInteger('source');

            $table->dateTime("created_at");
            $table->dateTime("updated_at");
        });
    }

    public function down()
    {
        Schema::dropIfExists("setting");
    }

}
