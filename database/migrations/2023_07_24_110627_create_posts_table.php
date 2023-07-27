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
        Schema::create('posts', function (Blueprint $table) {
            //main table, creating tables for Posts
            $table->id();
            $table->string(column:'title', length: 2048);
            $table->string(column:'slug', length: 2048);
            $table->string(column:'thumbnail', length: 2048)->nullable();
            $table->longText(column:'body');
            $table->boolean(column:'active');
            $table->datetime(column: 'published_at')->nullable();
            $table->foreignIdFor(model:\App\Models\User::class, column: 'user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};