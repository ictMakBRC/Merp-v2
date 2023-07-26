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
        Schema::create('assets_subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_category_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('subcategory_name');
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
        Schema::dropIfExists('assets_subcategories');
    }
};
