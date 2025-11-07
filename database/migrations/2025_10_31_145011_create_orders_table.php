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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('ord_id');
            $table->unsignedBigInteger('ord_user_id');
            $table->foreign('ord_user_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->string('ord_name_user');
            $table->bigInteger('ord_phone_number');
            $table->string('ord_subdistrict');
            $table->string('ord_adress_detail');
            $table->bigInteger('ord_packages_id');
            $table->string('ord_pickup_address');
            $table->string('ord_pickup_schedule');
            $table->string('ord_delivery_schedule');
            $table->bigInteger('ord_total_weight');
            $table->boolean('ord_status');
            $table->bigInteger('ord_total_price');
            $table->bigInteger('ord_pickup_courier_id')->nullable();
            $table->bigInteger('ord_delivery_courier_id')->nullable();
            $table->string('ord_order_code');
            $table->timestamps();
            $table->renameColumn('updated_at', 'ord_updated_at');
            $table->renameColumn('created_at', 'ord_created_at');
            $table->unsignedBigInteger('ord_created_by')->nullable();
            $table->unsignedBigInteger('ord_deleted_by')->nullable();
            $table->unsignedBigInteger('ord_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'ord_deleted_at');
            
            $table->string('ord_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
