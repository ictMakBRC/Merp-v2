<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('reference')->unique();
            $table->string('subject');
            $table->string('issue_type')->nullable();
            $table->foreignId('asset_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('priority')->nullable();
            $table->string('deadline')->nullable();
            $table->foreignId('station_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('source_dept')->nullable()->references('id')->on('departments')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('destination_dept')->nullable()->references('id')->on('departments')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->string('issue_status')->default('Pending');
            $table->longText('reason')->nullable();
            $table->unsignedbiginteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets_issues');
    }
};
