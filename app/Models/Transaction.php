<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        $date = now()->format('Ymd'); // Format: 20250415
        $lastId = self::max('id') + 1;
        return sprintf('%s-%s-%05d', $prefix, $date, $lastId);
        // Contoh hasil: INV-20250415-00001
    }
}
