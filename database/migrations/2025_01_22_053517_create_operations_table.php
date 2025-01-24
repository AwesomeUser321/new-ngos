<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_of_operation_id')->constrained('area_of_operations')->onDelete('cascade');
            $table->string('future_plan_file')->nullable();
            $table->string('plan_operation_file')->nullable();
            $table->string('progress_report_file')->nullable();
            $table->string('first_meeting_file')->nullable();
            $table->string('last_meeting_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
