<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecuringTransfer extends Model
{
    protected $fillable = [
        'source_id',
        'target_id',
        'amount',
        'frequency',
        'reason',
        'status',
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
        return $this->hasMany(RecuringTransferLog::class, 'transfer_id');
    }
}
