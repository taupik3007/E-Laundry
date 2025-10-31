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
            $table->unsignedBigInteger('adr_user_id');
            $table->foreign('ord_user_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->bigInteger('adr_phone_number');
            $table->string('adr_subdistrict');
            $table->string('adr_adress_detail');
            $table->bigInteger('ord_packages_id');
            $table->string('ord_pickup_address');
            $table->string('ord_pickup_schedule');
            $table->string('ord_delivery_schedule');
            $table->bigInteger('ord_total_weight');
            $table->boolean('ord_status');
            $table->bigInteger('ord_total_price');
            $table->bigInteger('ord_pickup_courier_id');
            $table->bigInteger('ord_delivery_courier_id');
            $table->string('ord_order_code');
            $table->timestamps();
            $table->renameColumn('updated_at', 'adr_updated_at');
            $table->renameColumn('created_at', 'adr_created_at');
            $table->unsignedBigInteger('adr_created_by')->nullable();
            $table->unsignedBigInteger('adr_deleted_by')->nullable();
            $table->unsignedBigInteger('adr_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'adr_deleted_at');
            // Kolom audit
            $table->unsignedBigInteger('adr_created_by')->nullable();
            $table->unsignedBigInteger('adr_deleted_by')->nullable();
            $table->unsignedBigInteger('adr_updated_by')->nullable();
            $table->string('adr_sys_note')->nullable();
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
