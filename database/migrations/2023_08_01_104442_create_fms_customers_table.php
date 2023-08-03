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
        Schema::create('fms_customers', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->string('title');
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();           
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->unique();
            $table->string('alt_email')->nullable()->unique();
            $table->string('contact')->nullable();
            $table->string('fax')->nullable();
            $table->string('alt_contact')->nullable();
            $table->string('website')->nullable();
            $table->string('company_name')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('payment_methos')->nullable();
            $table->double('Opening_balance',12,2)->default(0);
            $table->date('as_of')->nullable();
            $table->string('Sales_tax_registration')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('contract_id')->nullable();
            $table->foreignId('contract_file')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_customers');
    }
};
