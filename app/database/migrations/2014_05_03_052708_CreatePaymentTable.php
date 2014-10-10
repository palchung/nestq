<?php

use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration {

        public function up() {
                Schema::dropIfExists("payment");
                Schema::create("payment", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->dateTime('due_date')->nullable();
                        $table->smallInteger('account_id');
                        $table->decimal('amount', 5, 2);
                        $table->string('status', 1); // 0 stand for not pay
                        $table->smallInteger('period');
                        $table->smallInteger('pricing_id');
                });
        }

        public function down() {
                Schema::dropIfExists("payment");
        }

}
