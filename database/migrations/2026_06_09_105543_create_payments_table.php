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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_no', 100)->unique();
            $table->foreignId('member_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('payment_type', 150)->index();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date')->index();
            $table->enum('payment_method', ['cash', 'bank', 'mobile_banking', 'card', 'other'])->default('cash')->index();
            $table->enum('payment_status', ['due', 'partial', 'paid', 'waived', 'cancelled'])->default('due')->index();
            $table->string('transaction_reference', 150)->nullable()->index();
            $table->text('remarks')->nullable();
            $table->foreignId('received_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['member_id', 'payment_status']);
            $table->index(['event_id', 'payment_status']);
            $table->index(['payment_status', 'payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
