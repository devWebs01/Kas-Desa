<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'description',
        'amount',
        'signature',
        'signature_code',
        'authorized',
    ];

    public function transaction() 
    {
        return $this->belongsTo(Transaction::class);
    }
}
