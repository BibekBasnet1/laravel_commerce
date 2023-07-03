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
        Schema::create('user_roles',function(Blueprint $table)
        {
            // this is for the user id 
            $table->unsignedBigInteger('user');
            // this is for the user role
            $table->unsignedBigInteger('role');
            
            // this table is referenced to the user table 
            $table->foreign('user')->references('id')->on("users");

            // this table is referenced to the rolles table
            $table->foreign('role')->references('id')->on("roles");

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
