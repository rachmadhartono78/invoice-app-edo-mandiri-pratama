<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_code',
        'item_name',
        'description',
        'quantity',
        'unit',
        'unit_price',
        'discount_percentage',
        'discount_amount',
        'subtotal',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->calculateSubtotal();
        });
    }

    public function calculateSubtotal()
    {
        $total = $this->quantity * $this->unit_price;
        
        if ($this->discount_percentage > 0) {
            $this->discount_amount = $total * ($this->discount_percentage / 100);
        }
        
        $this->subtotal = $total - ($this->discount_amount ?? 0);
        
        return $this;
    }
}
