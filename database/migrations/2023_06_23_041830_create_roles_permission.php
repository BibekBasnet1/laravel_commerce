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
        Schema::create('roles_permission', function (Blueprint $table) 
        {
            /*
                Table rolles_id and the permission_id is the foreign key associated with the 
                roles table and the permission table 
            */
            $table->id();
            $table->unsignedBigInteger('roles_id');
            $table->unsignedBigInteger('permission_id');
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->foreign('permission_id')->references('id')->on('permisson');
        });
    }

    /**
     * Reverse the migrations.
    */

    public function down(): void
    {
        Schema::dropIfExists('roles_permission');
    }
};
