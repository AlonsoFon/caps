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
        Schema::table('sub_users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->string('sub_user_id')->default(null)->after("to_id");
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
