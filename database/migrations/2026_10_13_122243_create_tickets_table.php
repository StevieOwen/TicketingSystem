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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('description');
            $table->enum('issueType',['academic','finance','system']);
            $table->enum('status',['pending','accepted','processing','done','rejected'])->default('pending');
            $table->string('attachment');
            $table->string('rejection_motive')->nullable();
            $table->uuid('student_id');
            $table->foreign('student_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->uuid('officer_id')->nullable();
            $table->foreign('officer_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
