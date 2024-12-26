<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->integer('quantity')->default(1); // Add quantity column
        });
    }
    
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('quantity'); // Remove quantity column if rolling back
        });
    }
};    
