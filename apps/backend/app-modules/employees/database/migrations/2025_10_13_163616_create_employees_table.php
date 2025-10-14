<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('personal_email')->nullable();
            $table->string('profile_photo')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['employee_code', 'email']);
            $table->unique(['designation_id', 'department_id']);

            $table->index('department_id');
            $table->index('designation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('employees');
    }
};
