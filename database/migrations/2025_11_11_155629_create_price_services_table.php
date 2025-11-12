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
        Schema::create('price_services', function (Blueprint $table) {
            $table->bigIncrements('prs_id');
            $table->string('prs_package');
            $table->bigInteger('prs_price');
            $table->timestamps();
            $table->renameColumn('updated_at', 'prs_updated_at');
            $table->renameColumn('created_at', 'prs_created_at');
            $table->unsignedBigInteger('prs_created_by')->nullable();
            $table->unsignedBigInteger('prs_deleted_by')->nullable();
            $table->unsignedBigInteger('prs_updated_by')->nullable();
            $table->softDeletes(); // gunakan deleted_at
            $table->renameColumn('deleted_at', 'prs_deleted_at');
            $table->string('prs_sys_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_services');
    }
};
