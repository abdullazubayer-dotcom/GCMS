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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('member_code', 50)->unique();
            $table->date('joining_date')->nullable()->index();
            $table->enum('membership_type', ['general', 'lifetime', 'associate', 'honorary'])->default('general')->index();
            $table->enum('membership_status', ['active', 'inactive', 'suspended', 'cancelled'])->default('active')->index();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('occupation', 150)->nullable();
            $table->string('organization', 150)->nullable();
            $table->text('address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('emergency_contact_name', 150)->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['membership_status', 'membership_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
