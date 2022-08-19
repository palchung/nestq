<?php

use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration {

	public function up() {
		Schema::dropIfExists("admin");
		Schema::create("admin", function($table) {
			$table->engine = "InnoDB";

			$table->increments("id");
			$table->dateTime("created_at");
			$table->dateTime("updated_at");
			$table->string('username', 100)->unique();
			$table->string('password', 64);
			$table->string('remember_token', 100);
		});
	}

	public function down() {
		Schema::dropIfExists("admin");
	}

}
