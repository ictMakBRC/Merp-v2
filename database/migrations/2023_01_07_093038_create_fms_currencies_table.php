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
        Schema::dropIfExists('fms_currencies');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code',50)->unique();
            $table->boolean('is_active')->default(true);
            $table->boolean('system_default')->default(false);
            $table->float('exchange_rate')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        DB::statement("
            INSERT INTO `fms_currencies` ( `name`, `code`, `is_active`, `system_default`, `exchange_rate`, `created_at`, `updated_at`) VALUES ('Uganda Shillings', 'UGX', '1', '1', '1.00', '2023-08-02 19:24:27', '2023-08-01 19:24:27');
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_currencies');
    }
};
