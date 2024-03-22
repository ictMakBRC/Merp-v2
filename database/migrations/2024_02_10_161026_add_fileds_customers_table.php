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
        Schema::table('fms_customers', function (Blueprint $table) {
            $table->string('code',10)->after('name')->nullable();
            $table->foreignId('parent_id')->after('code')->nullable()->constrained('fms_customers','id')->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('opening_balance',16,2)->nullable()->after('current_balance')->default(0);
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
