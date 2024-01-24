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
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact')->nullable()->after('email');
            $table->text('funder_projects')->nullable()->after('contact');
            $table->text('monitored_departments')->nullable()->after('funder_projects');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('password_updated_at','password_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
