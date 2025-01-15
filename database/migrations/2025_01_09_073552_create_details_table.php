<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('father_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('qualification');
            $table->string('designation');
            $table->string('occupation');
            $table->string('email')->unique();
            $table->string('contact');
            $table->text('address');
            $table->string('cnic');
            $table->string('cv')->nullable();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->timestamps();
        
            $table->foreign('city_id')->references('city_id')->on('cities')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
}
