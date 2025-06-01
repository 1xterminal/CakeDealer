<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payments extends Model
{
    use HasFactory, HasMany;

    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'amount',
        'payment_date',
        'payment_method',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function paymentItems()
    {
        return $this->hasMany(Payment_Items::class);
    }
}
