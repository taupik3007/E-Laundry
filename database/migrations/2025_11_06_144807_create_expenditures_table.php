<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenditures', function (Blueprint $table) {
            $table->bigIncrements('exp_id');
            $table->unsignedBigInteger('exp_user_id'); 
            $table->unsignedBigInteger('exp_laundryservice_id'); 
            $table->string('exp_detail');
            $table->decimal('exp_amount', 15, 2);
            $table->date('exp_date');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exp_user_id')->references('usr_id')->on('users');
            $table->foreign('exp_laundryservice_id')->references('ldp_id')->on('laundry_packages');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenditures');
    }
};
