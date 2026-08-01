<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'unit',
        'cost_price',
        'sale_price',
        'reorder_level',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
