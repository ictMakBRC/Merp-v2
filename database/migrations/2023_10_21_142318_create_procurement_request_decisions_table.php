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
        Schema::create('procurement_request_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_request_id')->nullable()->references('id')->on('procurement_requests', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict')->after('procurement_categorization_id');
            $table->string('decision_maker');
            $table->string('decision');
            $table->string('step');
            $table->text('comment');
            $table->date('decision_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_request_decisions');
    }
};
