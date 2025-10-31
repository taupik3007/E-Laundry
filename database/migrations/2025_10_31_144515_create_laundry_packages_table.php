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
        Schema::create('laundry_packages', function (Blueprint $table) {
            $table->bigIncrements('ldp_id');
            $table->bigInteger('ldp_price');
            $table->string('ldp_name');
            $table->string('ldp_description');
            $table->string('ldp_duration');
            $table->timestamps();
            $table->renameColumn('updated_at', 'ldp_updated_at');
            $table->renameColumn('created_at', 'ldp_created_at');
            $table->unsignedBigInteger('ldp_created_by')->nullable();
            $table->unsignedBigInteger('ldp_deleted_by')->nullable();
            $table->unsignedBigInteger('ldp_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'ldp_deleted_at');
            // Kolom audit
            $table->unsignedBigInteger('ldp_created_by')->nullable();
            $table->unsignedBigInteger('ldp_deleted_by')->nullable();
            $table->unsignedBigInteger('ldp_updated_by')->nullable();
            $table->string('ldp_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_packages');
    }
};
