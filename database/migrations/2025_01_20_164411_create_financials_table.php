<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_bank_account'); // Yes or No for bank account
            $table->foreignId('bank_id')->nullable()->constrained('banks')->onDelete('set null'); // Foreign key to `banks`
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('income_expenditure_file')->nullable(); // For file upload
            $table->foreignId('prop_finan_id')->nullable()->constrained('proposed_finances')->onDelete('set null'); // Foreign key
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
        Schema::dropIfExists('financials');
    }
}
