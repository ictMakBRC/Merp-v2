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
        Schema::create('grant_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('grant_code');
            $table->string('grant_name');
            $table->string('grant_type')->nullable();
            $table->string('funding_source')->nullable();
            $table->decimal('funding_amount', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('proposal_submission_date');
            $table->string('principal_investigator');
            $table->longText('proposal_summary')->nullable();
            $table->string('award_status');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grant_profiles');
    }
};
