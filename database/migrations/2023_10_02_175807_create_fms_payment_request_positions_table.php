<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fms_payment_request_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('name_lock')->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->timestamps();
        });
        DB::statement("
            INSERT INTO `fms_payment_request_positions` (`id`, `name`, `name_lock`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_active`) VALUES
            (1, 'Principal Investigator/ Manager/Unit Head', 'pi_manager', 1, NULL, NULL, NULL, 1),
            (2, 'Grants Office/ Manager', 'grants', NULL, NULL, NULL, NULL, 1),
            (3, 'Internal Audit', 'audit', 1, NULL, NULL, NULL, 1),
            (4, 'Finance/ Manager/Unit Head', 'finance', 1, NULL, NULL, NULL, 1),
            (5, 'Operations Manager', 'operations', 1, NULL, '2023-10-02 19:15:11', NULL, 1),
            (6, 'Managing Director', 'director', 1, NULL, NULL, NULL, 1);
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_payment_request_positions');
    }
};
