<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory_Logs extends Model
{
    use HasFactory, HasMany;

    protected $table = 'inventory__logs';

    protected $fillable = [
        'product_id',
        'quantity',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
