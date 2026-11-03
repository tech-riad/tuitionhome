<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceNote extends Model
{
    protected $fillable = [
        'invoice_id',
        'user_id',
        'note',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
