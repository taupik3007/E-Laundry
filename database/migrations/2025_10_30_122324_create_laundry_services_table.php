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
        Schema::create('laundry_services', function (Blueprint $table) {
            $table->bigIncrements('lds_id');
            $table->string('lds_name');
            $table->string('lds_image');
            $table->timestamps();
            $table->renameColumn('updated_at', 'lds_updated_at');
            $table->renameColumn('created_at', 'lds_created_at');
            $table->unsignedBigInteger('lds_created_by')->nullable();
            $table->unsignedBigInteger('lds_deleted_by')->nullable();
            $table->unsignedBigInteger('lds_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'lds_deleted_at');
            $table->string('lds_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_services');
    }
};
