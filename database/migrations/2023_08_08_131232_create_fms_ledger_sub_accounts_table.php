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
        // Schema::create('fms_ledger_sub_accounts', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->unique();
        //     $table->string('code')->unique();            
        //     $table->string('account_number')->unique();
        //     $table->foreignId('ledger_account')->nullable()->constrained('fms_ledger_accounts','id')->onUpdate('cascade')->onDelete('restrict');
        //     $table->foreignId('account_type')->nullable()->references('id')->on('fms_chart_of_accounts_types')->onDelete('restrict')->onUpdate('cascade');
        //     $table->double('opening_balance',16,2);
        //     $table->double('current_balance',16,2);
        //     $table->date('as_of');
        //     $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
        //     $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
        //     $table->boolean('is_active')->default(True);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_ledger_sub_accounts');
    }
};
