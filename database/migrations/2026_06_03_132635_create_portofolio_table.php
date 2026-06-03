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
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('type', 50); // contoh: 'link', 'file', 'github', 'youtube', dll
            $table->string('link_url', 500)->nullable();
            $table->string('file_url', 500)->nullable();
            $table->bigInteger('file_size')->unsigned()->nullable(); // ukuran file dalam bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};
