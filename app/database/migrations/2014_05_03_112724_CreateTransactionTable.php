<?php

use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration {

        public function up() {
                Schema::dropIfExists("transaction");
                Schema::create("transaction", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->smallInteger('payment_id');
                        $table->string('channel', 10);
                        $table->string('transaction_id', 100);
                        $table->string('token', 100);
                });
        }

        public function down() {
                Schema::dropIfExists("transaction");
        }

}
