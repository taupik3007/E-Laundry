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
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('odt_id');

            $table->unsignedBigInteger('odt_order_id');
            $table->foreign('odt_order_id')->references('ord_id')->on('orders')->onDelete('cascade');
        
            $table->unsignedBigInteger('odt_service_id');
            $table->foreign('odt_service_id')->references('lds_id')->on('laundry_services')->onDelete('cascade');
            $table->unsignedBigInteger('odt_package_id');
            $table->foreign('odt_package_id')->references('ldp_id')->on('laundry_packages')->onDelete('cascade');
        
            $table->integer('odt_quantity')->nullable();;
            $table->integer('odt_price')->nullable();;
            $table->integer('odt_total')->nullable();;
            $table->timestamps();
            $table->renameColumn('updated_at', 'odt_updated_at');
            $table->renameColumn('created_at', 'odt_created_at');
            $table->unsignedBigInteger('odt_created_by')->nullable();
            $table->unsignedBigInteger('odt_deleted_by')->nullable();
            $table->unsignedBigInteger('odt_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'odt_deleted_at');
            
            $table->string('odt_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
