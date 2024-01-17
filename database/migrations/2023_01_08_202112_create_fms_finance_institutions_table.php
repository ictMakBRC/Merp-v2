<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('fms_finance_institutions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('fms_finance_institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('contact')->nullable();
            $table->string('type',50)->default('Bank');
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    //     Schema::table('banking_information', function (Blueprint $table) {
    //         $table->foreignId('bank_id')->nullable()->constrained('fms_finance_institutions', 'id')->onUpdate('cascade')->onDelete('restrict');
    //     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_finance_institutions');
    }
};
