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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('event_date')->index();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('venue')->nullable();
            $table->text('description')->nullable();
            $table->decimal('event_fee', 10, 2)->default(0);
            $table->unsignedInteger('capacity')->nullable();
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft')->index();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
