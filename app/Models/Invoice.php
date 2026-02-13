<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'customer_name',
        'customer_address',
        'customer_phone',
        'customer_email',
        'payment_terms',
        'notes',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'tax_percentage',
        'tax_amount',
        'other_charges',
        'total_amount',
        'status',
        'prepared_by',
        'approved_by',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'other_charges' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (!$invoice->invoice_number) {
                $invoice->invoice_number = self::generateInvoiceNumber();
            }
        });
    }

    public static function generateInvoiceNumber()
    {
        $year = date('Y');
        $month = date('m');

        $lastInvoice = self::whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = intval(substr($lastInvoice->invoice_number, -5));
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        }
        else {
            $newNumber = '00001';
        }

        return "SI.{$year}.{$month}.{$newNumber}";
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });

        $this->discount_amount = $this->subtotal * ($this->discount_percentage / 100);

        $afterDiscount = $this->subtotal - $this->discount_amount;

        $this->tax_amount = $afterDiscount * ($this->tax_percentage / 100);

        $this->total_amount = $afterDiscount + $this->tax_amount + ($this->other_charges ?? 0);

        return $this;
    }
}
