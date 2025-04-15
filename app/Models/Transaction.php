<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'category',
        'amount',
        'invoice',
        'date',
        'description',
        'recipient_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'recipient_id' => 'integer',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->invoice = self::generateInvoiceNumber();
        });
    }

    protected static function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $date = now()->format('ymd'); // Format: 240415
        $random = strtoupper(Str::random(5)); // 5 karakter acak, huruf & angka

        return "{$prefix}-{$date}-{$random}";
    }
}
