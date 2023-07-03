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
        Schema::create('slider', function (Blueprint $table) 
        {
            // table attributes creation  when we assign the 
            $table->id();
            // this is for the name of slider 
            $table->string('name');
            // this is for the name of the caption of the slider image
            $table->string('caption');
            // this is for name and path of the image
            $table->string('image');
            // this is for creation of the category id 
            $table->unsignedBigInteger('category_id');
            // this is used to create a foreign key relationship with the category table 
            $table->foreign('category_id')->references('id')->on('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider');
    }
};
