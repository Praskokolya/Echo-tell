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
        Schema::dropIfExists("messages");
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('user_id');
            $table->integer('sender_id');
            $table->string('message', 200);
            $table->string('user', 20);
            $table->string('sender_name');
            $table->integer('name_visibility')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table){
            Schema::dropIfExists('messages');
        });
    }
};
