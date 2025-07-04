<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $source_id
 * @property int $target_id
 * @property int $amount
 * @property int $frequency
 * @property string $reason
 * @property CarbonImmutable $start_at
 * @property CarbonImmutable $end_at
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
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
        'start_at' => 'immutable_datetime',
        'end_at' => 'immutable_datetime',
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
