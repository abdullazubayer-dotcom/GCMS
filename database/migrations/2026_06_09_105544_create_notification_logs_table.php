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
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->enum('channel', ['email', 'sms', 'system'])->index();
            $table->string('recipient', 150)->nullable()->index();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending')->index();
            $table->timestamp('sent_at')->nullable()->index();
            $table->text('error_message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'channel']);
            $table->index(['status', 'sent_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
