<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('details_id')->unsigned();
            $table->bigInteger('member_type_id')->unsigned();
            $table->timestamps();
        
            $table->foreign('details_id')->references('id')->on('details')->onDelete('cascade');
            $table->foreign('member_type_id')->references('id')->on('membership_types')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
