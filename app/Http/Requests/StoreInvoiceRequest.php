<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_phone' => 'nullable|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'payment_terms' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'other_charges' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,pending,paid,cancelled',
            'prepared_by' => 'nullable|string|max:255',
            'approved_by' => 'nullable|string|max:255',
            
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|string|max:50',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit' => 'required|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages()
    {
        return [
            'invoice_date.required' => 'Tanggal invoice harus diisi',
            'customer_name.required' => 'Nama customer harus diisi',
            'items.required' => 'Minimal harus ada 1 item',
            'items.*.item_code.required' => 'Kode item harus diisi',
            'items.*.item_name.required' => 'Nama item harus diisi',
            'items.*.quantity.required' => 'Jumlah harus diisi',
            'items.*.unit.required' => 'Satuan harus diisi',
            'items.*.unit_price.required' => 'Harga satuan harus diisi',
        ];
    }
}
