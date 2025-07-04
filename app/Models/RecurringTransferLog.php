<?php

namespace App\Models;

use App\Enums\RecurringTransferStatus;
use Carbon\CarbonImmutable;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $transfer_id
 * @property string $comment
 * @property RecurringTransferStatus $status
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
class RecurringTransferLog extends Model
{
    use HasFactory, Timestamp;

    protected $fillable = [
        'transfer_id',
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => 'string',
        'comment' => 'string',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public function transfer()
    {
        return $this->belongsTo(RecurringTransfer::class, 'transfer_id');
    }
}
