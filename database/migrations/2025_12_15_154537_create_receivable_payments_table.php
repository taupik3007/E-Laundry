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
        Schema::create('receivable_payments', function (Blueprint $table) {
            $table->id('rp_id');
            $table->unsignedBigInteger('rp_order_id');
            $table->foreign('rp_order_id')->references('ord_id')->on('orders')->onDelete('cascade');

            $table->bigInteger('rp_amount_paid');
            $table->bigInteger('rp_remaining');
            $table->datetime('rp_paid_at');

            $table->timestamps();
            $table->renameColumn('updated_at', 'rp_updated_at');
            $table->renameColumn('created_at', 'rp_created_at');
            $table->unsignedBigInteger('rp_created_by')->nullable();
            $table->unsignedBigInteger('rp_deleted_by')->nullable();
            $table->unsignedBigInteger('rp_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'rp_deleted_at');
            
            $table->string('rp_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivable_payments');
    }
};
