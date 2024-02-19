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
        Schema::create('inv_unit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_code')->nullable();
            $table->string('request_type')->default('Internal');
            $table->unsignedBigInteger('borrower_id')->nullable();
            $table->string('borrow_state')->default('na');
            $table->boolean('is_active')->default(false);
            $table->dateTime('date_added')->nullable();
            $table->tinyText('comment')->nullable();
            $table->enum('status',['Pending','Submitted','Approved','Declined','Processed','Acknowledged'])->default('Pending');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');  
            $table->foreignId('approved_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->datetime('approved_at')->nullable();
            $table->tinyText('approval_comment')->nullable(); 
            $table->foreignId('processed_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->datetime('processed_at')->nullable();
            $table->tinyText('processor_comment')->nullable(); 
            $table->foreignId('acknowledged_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->datetime('acknowledged_at')->nullable();
            $table->tinyText('acknowledgement')->nullable();  
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->morphs('unitable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_unit_requests');
    }
};
