<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $transfer_id
 * @property string $reason
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
class RecurringTransfer extends Model
{
    use HasFactory, Timestamp;

    protected $fillable = [
        'source_id',
        'target_id',
        'amount',
        'frequency',
        'reason',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function source()
    {
        return $this->belongsTo(Wallet::class, 'source_id');
    }

    public function target()
    {
        return $this->belongsTo(Wallet::class, 'target_id');
    }

    public function logs()
    {
        return $this->hasMany(RecurringTransferLog::class, 'transfer_id');
    }
}
