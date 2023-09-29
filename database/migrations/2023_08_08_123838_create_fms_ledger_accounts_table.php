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
        Schema::dropIfExists('fms_ledger_sub_accounts');        
        Schema::dropIfExists('fms_ledger_accounts');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_ledger_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('parent_id')->nullable();            
            $table->foreignId('account_type')->nullable()->references('id')->on('fms_chart_of_accounts_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->onDelete('restrict')->onUpdate('cascade');
            $table->string('account_number')->unique();
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');  
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict');   
            $table->double('opening_balance',16,2)->default(0.00);
            $table->double('current_balance',16,2)->default(0.00);
            $table->double('amount_held',16,2)->default(0.00);
            $table->date('as_of');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->boolean('is_active')->default(1);
            $table->tinyText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_ledger_accounts');
    }
};
