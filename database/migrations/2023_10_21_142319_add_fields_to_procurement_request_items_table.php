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
        Schema::table('procurement_request_items', function (Blueprint $table) {
            $table->float('bidder_unit_cost',12,2)->nullable()->after('total_cost');
            $table->float('bidder_total_cost',12,2)->nullable()->after('bidder_unit_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_request_items');
    }
};
