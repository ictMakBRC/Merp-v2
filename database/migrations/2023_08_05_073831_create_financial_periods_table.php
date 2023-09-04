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
        Schema::create('fms_financial_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

       
            $year = date('Y'); // Get the current year
        
            DB::table('fms_financial_periods')->insert([
                [
                    'name' => 'Q1',
                    'start_date' => $year . '-01-01',
                    'end_date' => $year . '-03-31',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Q2',
                    'start_date' => $year . '-04-01',
                    'end_date' => $year . '-06-30',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Q3',
                    'start_date' => $year . '-07-01',
                    'end_date' => $year . '-09-30',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Q4',
                    'start_date' => $year . '-10-01',
                    'end_date' => $year . '-12-31',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_periods');
    }
};
