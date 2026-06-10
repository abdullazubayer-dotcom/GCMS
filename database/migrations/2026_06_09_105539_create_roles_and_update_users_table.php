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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('display_name', 100);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('login_id', 50)->unique()->after('role_id');
            $table->string('phone', 30)->nullable()->after('email')->index();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('password')->index();
            $table->timestamp('last_login_at')->nullable()->after('status');
            $table->foreignId('created_by')->nullable()->after('last_login_at')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            $table->softDeletes();

            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropUnique(['login_id']);
            $table->dropIndex(['phone']);
            $table->dropIndex(['status']);
            $table->dropIndex(['email']);
            $table->dropSoftDeletes();
            $table->dropColumn([
                'role_id',
                'login_id',
                'phone',
                'status',
                'last_login_at',
                'created_by',
                'updated_by',
            ]);
        });

        Schema::dropIfExists('roles');
    }
};
