<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 30)->unique();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 30)->unique();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('student_subject', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->primary(['student_id', 'subject_id']);
        });

        Schema::create('student_extracurricular', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->onDelete('cascade');
            $table->primary(['student_id', 'extracurricular_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_extracurricular');
        Schema::dropIfExists('student_subject');
        Schema::dropIfExists('extracurriculars');
        Schema::dropIfExists('subjects');
    }
};
