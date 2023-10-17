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
        Schema::create('procurement_request_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_request_id')->constrained('procurement_requests', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('approver_id')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->text('comment')->nullable();
            $table->enum('status', ['Submitted','Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->enum('step', ['Department', 'Supervisor', 'Finance', 'Operations', 'Md', 'Procurement']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_request_approvals');
    }
};
