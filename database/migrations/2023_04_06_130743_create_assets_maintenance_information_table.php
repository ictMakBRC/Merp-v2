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
        Schema::create('assets_maintenance_information', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->foreignId('authorised_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('issue_ref')->references('reference')->on('asset_issues')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('vendor')->nullable()->references('id')->on('vendors')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('internal_vendor')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->longText('recommendation')->nullable();
            $table->date('maintenance_date')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('assets_maintenance_information');
    }
};
