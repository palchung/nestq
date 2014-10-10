<?php

use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration {

        public function up() {
                Schema::dropIfExists("account");
                Schema::create("account", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->dateTime("deleted_at");
                        $table->string('firstname', 20);
                        $table->string('lastname', 20);
                        $table->string('email', 100)->unique();
                        $table->string('password', 64);
                        $table->string('cell_tel', 15)->nullable();
                        $table->string('tel', 15);
                        $table->string('identity', 1);
                        $table->integer('rating')->nullable();
                        $table->string('company', 255)->nullable();
                        $table->string('license', 255)->nullable();
                        $table->longText('description')->nullable();
                        $table->longText('template')->nullable();
                        $table->string('profile_pic', 255)->nullable();
                        $table->dateTime('last_seen');
                        $table->smallInteger('permission'); // 0 = super admin ~ 3 = normal user
                        $table->string('remember_token', 100);
                });
        }

        public function down() {
                Schema::dropIfExists("account");
        }

}
