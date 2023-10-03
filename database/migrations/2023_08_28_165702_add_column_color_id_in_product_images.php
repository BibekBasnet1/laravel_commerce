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
        Schema::table('product_images', function (Blueprint $table) {

                $table->unsignedBigInteger('color_id')->nullable();

                $table->foreign('color_id')->references('id')->on('product_colors');

                // $table->foreignId('color_id')
                //     ->constrained('product_colors')
                //     ->after('product_id'); 
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {

                $table->dropForeign(['color_id']);
                $table->dropColumn('color_id');
            
        });
    }
};
