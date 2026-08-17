<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 30)->unique();
            $table->string('name', 191);
            $table->string('npsn', 20);
            $table->string('nss', 20)->nullable();
            $table->string('academic_year', 9);
            $table->text('address');
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('village', 100);
            $table->string('district', 100);
            $table->string('regency', 100);
            $table->string('province', 100);
            $table->string('headmaster_name', 150);
            $table->string('tu_head_name', 150)->nullable();
            $table->string('headmaster_nip', 50);
            $table->string('tu_head_nip', 50)->nullable();
            $table->string('headmaster_period', 50)->nullable();
            $table->string('tu_head_period', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 30)->unique();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('username', 100)->unique();
            $table->string('email', 191)->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'staff']);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('schools');
    }
};
