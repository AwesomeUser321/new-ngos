<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicsAimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basics_aim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('basic_info_id')->constrained('basic_information')->onDelete('cascade');
            $table->foreignId('aim_obj_id')->constrained('aim_objective_table')->onDelete('cascade');
            $table->timestamps();

            // $table->foreign('basic_info_id')->references('id')->on('basic_information')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basics_aims');
    }
}
