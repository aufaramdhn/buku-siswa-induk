<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 30)->unique();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nipd', 20)->unique();
            $table->string('name', 150)->index();
            $table->enum('gender', ['L', 'P']);
            $table->string('nisn', 10)->unique();
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('religion', 30);
            $table->string('email', 100)->nullable();
            $table->string('mobile_phone', 20);
            $table->string('phone', 20)->nullable();
            $table->string('previous_school', 150)->nullable();
            $table->text('family_card_no');
            $table->string('rombel', 50)->index();
            $table->timestamps();
        });

        Schema::create('student_addresses', function (Blueprint $table) {
            $table->foreignId('student_id')->primary()->constrained('students')->onDelete('cascade');
            $table->text('address');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('dusun', 100)->nullable();
            $table->string('village', 100);
            $table->string('district', 100);
            $table->string('postal_code', 5);
            $table->string('residence_type', 50);
            $table->string('transportation', 50);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });

        Schema::create('student_parents', function (Blueprint $table) {
            $table->foreignId('student_id')->primary()->constrained('students')->onDelete('cascade');
            $table->string('father_name', 150);
            $table->string('father_birth_year', 4);
            $table->string('father_education', 50);
            $table->string('father_occupation', 100);
            $table->string('father_income', 50);
            $table->text('father_nik');
            $table->string('mother_name', 150);
            $table->string('mother_birth_year', 4);
            $table->string('mother_education', 50);
            $table->string('mother_occupation', 100);
            $table->string('mother_income', 50);
            $table->text('mother_nik');
            $table->string('guardian_name', 150)->nullable();
            $table->string('guardian_birth_year', 4)->nullable();
            $table->string('guardian_education', 50)->nullable();
            $table->string('guardian_occupation', 100)->nullable();
            $table->string('guardian_income', 50)->nullable();
            $table->text('guardian_nik')->nullable();
            $table->integer('siblings');
            $table->integer('birth_order');
            $table->timestamps();
        });

        Schema::create('student_academics', function (Blueprint $table) {
            $table->foreignId('student_id')->primary()->constrained('students')->onDelete('cascade');
            $table->string('skhun_number', 30)->nullable();
            $table->string('un_number', 30)->nullable();
            $table->string('ijazah_number', 30)->nullable();
            $table->string('akta_number', 50);
            $table->integer('weight');
            $table->integer('height');
            $table->integer('head_circum');
            $table->decimal('school_dist_km', 5, 2);
            $table->timestamps();
        });

        Schema::create('student_financials', function (Blueprint $table) {
            $table->foreignId('student_id')->primary()->constrained('students')->onDelete('cascade');
            $table->boolean('is_kps')->default(false);
            $table->string('kps_number', 50)->nullable();
            $table->boolean('is_kip')->default(false);
            $table->string('kip_number', 50)->nullable();
            $table->string('kip_name', 150)->nullable();
            $table->string('kks_number', 50)->nullable();
            $table->boolean('is_pip_eligible')->default(false);
            $table->text('pip_reason')->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->text('bank_account')->nullable();
            $table->string('bank_holder', 150)->nullable();
            $table->string('special_needs', 100)->default('Tidak Ada');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_financials');
        Schema::dropIfExists('student_academics');
        Schema::dropIfExists('student_parents');
        Schema::dropIfExists('student_addresses');
        Schema::dropIfExists('students');
    }
};
