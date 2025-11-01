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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigInteger('pym_id');
            $table->bigInteger('pym_order_id');
            $table->bigInteger('pym_order_method');
            $table->string('pym_payment_gateaway');
            $table->string('pym_gateaway_references');
            $table->string('pym_qrcode_url');
            $table->boolean('pym_payment_status');
            $table->bigInteger('pym_amount');
            $table->datetime('pym_paid_at');
            $table->datetime('pym_expiry_time');
            $table->string('pym_raw_response');
            $table->renameColumn('updated_at', 'pym_updated_at');
            $table->renameColumn('created_at', 'pym_created_at');
             $table->unsignedBigInteger('pym_created_by')->nullable();
            $table->unsignedBigInteger('pym_deleted_by')->nullable();
            $table->unsignedBigInteger('pym_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'pym_deleted_at');
            $table->string('pym_sys_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
