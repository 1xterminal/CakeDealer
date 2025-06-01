<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    use HasFactory, HasMany;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(Order_Items::class);
    }

    public function inventoryLogs(): HasMany
    {
        return $this->hasMany(Inventory_Logs::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
