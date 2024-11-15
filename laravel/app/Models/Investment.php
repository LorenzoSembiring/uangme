<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $table = 'investments';

    protected $fillable = [
        'user_id',
        'amount',
        'bank_code',
        'va_number',
        'investment_date',
    ];

    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_id');
    }
}
