<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    use HasFactory, HasMany;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'order_date',
        'status',
        'total_amount',
    ];

    public function orderItems()
    {
        return $this->hasMany(Order_Items::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
