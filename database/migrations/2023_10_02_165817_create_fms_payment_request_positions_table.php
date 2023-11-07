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
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('fms_payment_request_positions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_payment_request_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('name_lock')->unique();
            $table->integer('level')->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('assigned_to')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->timestamps();
        });
        DB::statement("
            INSERT INTO `fms_payment_request_positions` (`level`, `name`, `name_lock`,`created_by`, `updated_by`, `created_at`, `updated_at`, `is_active`) VALUES
            (1, 'Principal Investigator/ Manager/Unit Head', 'head', NULL, NULL, NULL, NULL, 1),
            (2, 'Grants Office/ Manager', 'grants', NULL, NULL, NULL, NULL, 1),
            (3, 'Internal Audit', 'audit', NULL, NULL, NULL, NULL, 1),
            (4, 'Finance/ Manager/Unit Head', 'finance', NULL, NULL, NULL, NULL, 1),
            (5, 'Operations Manager', 'operations', NULL, NULL, NULL, NULL, 1),
            (6, 'Managing Director', 'director', NULL, NULL, NULL, NULL, 1);
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
