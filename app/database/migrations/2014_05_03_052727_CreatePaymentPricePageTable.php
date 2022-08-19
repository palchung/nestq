<?php

use Illuminate\Database\Migrations\Migration;

class CreatePaymentPricePageTable extends Migration {

        public function up() {

                Schema::dropIfExists("payment_pricepage");

                Schema::create("payment_pricepage", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->integer("payment_id")->unsigned();
                        $table->integer("pricepage_id")->unsigned();
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");

                        $table->foreign('payment_id')->references('id')->on('payment')->onDelete('cascade');
                        $table->foreign('pricepage_id')->references('id')->on('pricepage')->onDelete('cascade');
                });
        }

        public function down() {
                Schema::dropIfExists("payment_pricepage");
        }

}
