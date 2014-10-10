<?php

use Illuminate\Database\Migrations\Migration;

class CreateOauthProviderTable extends Migration {

        public function up() {
                Schema::dropIfExists("oauth");
                Schema::create("oauth", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->smallInteger('account_id');
                        $table->string('provider', 5);
                });
        }

        public function down() {
                Schema::dropIfExists("oauth");
        }

}
