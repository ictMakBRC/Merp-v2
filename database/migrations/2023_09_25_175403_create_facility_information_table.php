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
        Schema::create('facility_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facility_name');
            $table->string('slogan');
            $table->text('about');
            $table->string('facility_type');
            $table->string('physical_address');
            $table->string('address2')->nullable();
            $table->string('contact');
            $table->string('contact2')->nullable();
            $table->string('email')->nullable();
            $table->string('email2')->nullable();
            $table->string('tin')->nullable();
            $table->string('website')->nullable();
            $table->string('fax')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo2')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
        DB::Statement("
        INSERT INTO `facility_information` (`id`, `facility_name`, `slogan`, `about`, `facility_type`, `physical_address`, `address2`, `contact`, `contact2`, `email`, `email2`, `tin`, `website`, `fax`, `logo`, `logo2`, `created_by`, `created_at`, `updated_at`) VALUES
        (1, 'MAKERERE UNIVERSITY BIOMEDICAL RESEARCH CENTRE', 'Excellence in BioMedical Research', 'Biomedical Research facility which is under Makerere University Uganda', 'GOVERMENT', 'Clock Tower Kampala, Uganda', 'P.O BOX 75018', '+256390554433', NULL, 'makbrc.mak@gmail.com', NULL, NULL, 'https://brc.mak.ac.ug', NULL, 'facilitylogo/logo.png', 'facilitylogo/logo2.png', 11, '2022-07-26 16:57:56', '2023-06-07 04:26:37');

        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_information');
    }
};
