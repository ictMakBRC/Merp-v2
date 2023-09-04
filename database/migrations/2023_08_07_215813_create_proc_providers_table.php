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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('provider_code');
            $table->string('name');
            $table->string('provider_type');
            $table->string('phone_number');
            $table->string('alt_phone_number')->nullable();
            $table->string('email');
            $table->string('alt_email')->nullable();
            $table->string('full_address');
            $table->string('contact_person');
            $table->string('contact_person_phone');
            $table->string('contact_person_email');
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('payment_method');
            $table->string('bank_name');
            $table->string('branch');
            $table->string('account_name');
            $table->string('bank_account');
            $table->string('tin');
            $table->decimal('tax_withholding_rate', 5, 2)->nullable();
            $table->string('preferred_currency');
            // $table->decimal('delivery_performance', 5, 2)->nullable();
            // $table->decimal('quality_ratings', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
