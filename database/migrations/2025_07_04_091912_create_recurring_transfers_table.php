<?php

declare(strict_types=1);

use App\Enums\RecurringTransferStatus;
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
        Schema::create('recurring_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('wallets');
            $table->foreignId('target_id')->constrained('wallets');
            $table->date('start_at');
            $table->date('end_at');
            $table->integer('amount')->unsigned();
            $table->integer('frequency')->unsigned();
            $table->text('reason');
            $table->timestamps();
        });

        Schema::create('recurring_transfer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('recurring_transfers');
            $table->enum('status', array_column(RecurringTransferStatus::cases(), 'value'));
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_transfer_logs');
        Schema::dropIfExists('recurring_transfers');
    }
};
