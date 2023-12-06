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
        Schema::dropIfExists('fms_payrolls');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('payment_voucher',50)->unique();           
            $table->integer('month');
            $table->integer('year');   
            $table->enum('status',['Pending','Submitted','Rejected','Approved','Paid','Completed'])->default('Pending');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_payrolls');
    }
};
