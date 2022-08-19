<?php

use Illuminate\Database\Migrations\Migration;

class CreateRequisitionTable extends Migration {

        public function up() {

                Schema::dropIfExists("requisition");

                Schema::create("requisition", function($table) {
                        $table->engine = "InnoDB";

                        $table->increments("id");
                        $table->dateTime("created_at");
                        $table->dateTime("updated_at");
                        $table->smallInteger('property_id');
                        $table->smallInteger('agent_id');
                        $table->longText('requestmessage');
                                              
                        
                });
        }

        public function down() {
                Schema::dropIfExists("requisition");
        }

}
