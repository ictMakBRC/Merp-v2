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
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('alt_phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('full_address')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('alt_bank_account')->nullable();
            $table->string('tin')->nullable();
            $table->decimal('tax_withholding_rate', 5, 2)->nullable();
            $table->text('products_services')->nullable();
            $table->string('preferred_currency')->nullable();
            $table->text('pricing_agreement')->nullable();
            $table->decimal('delivery_performance', 5, 2)->nullable();
            $table->decimal('quality_ratings', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('provider_type')->nullable();
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
