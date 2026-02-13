@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <!-- Left: Navigation -->
    <a href="{{ url('/invoices') }}" style="text-decoration: none; color: var(--text-secondary); font-weight: 500; transition: color 0.2s; display: inline-flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.color='var(--text-color)'" onmouseout="this.style.color=''">
        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Invoices
    </a>

    <!-- Right: Action Group -->
    <div style="display: flex; gap: 0.75rem; align-items: center;">
        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.5rem; opacity: 0.7; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                Delete
            </button>
        </form>

        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; font-size: 0.875rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Edit
        </a>

        <a href="{{ route('invoices.preview', $invoice) }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.25rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"></path><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><path d="M6 14h12v8H6z"></path></svg>
            Print / Preview
        </a>
    </div>
</div>

<div class="card">
    <!-- Invoice Header -->
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 2px solid var(--border-color);">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; margin: 0 0 0.5rem 0;">Invoice #{{ $invoice->invoice_number }}</h1>
            <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                @if($invoice->status === 'paid')
                    <span style="background-color: #d1fae5; color: #065f46; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">✓ Paid</span>
                @elseif($invoice->status === 'pending')
                    <span style="background-color: #fef3c7; color: #92400e; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">⏱ Pending</span>
                @else
                    <span style="background-color: #fee2e2; color: #991b1b; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">✗ {{ ucfirst($invoice->status) }}</span>
                @endif
            </div>
        </div>
        <div style="text-align: right;">
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">Invoice Date</p>
            <p style="font-size: 1.125rem; font-weight: 600; margin: 0.25rem 0 0 0;">{{ $invoice->invoice_date->format('M d, Y') }}</p>
            @if($invoice->due_date)
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0.75rem 0 0 0;">Due Date</p>
            <p style="font-size: 1rem; font-weight: 500; margin: 0.25rem 0 0 0; color: #dc2626;">{{ $invoice->due_date->format('M d, Y') }}</p>
            @endif
        </div>
    </div>

    <!-- Customer Info -->
    <div style="margin-bottom: 2rem;">
        <h4 style="color: var(--text-secondary); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.75rem 0;">Bill To:</h4>
        <div style="background-color: var(--table-header-bg); padding: 1rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
            <p style="font-weight: 600; font-size: 1.125rem; margin: 0 0 0.25rem 0;">{{ $invoice->customer_name }}</p>
            @if($invoice->customer_email)
            <p style="color: var(--text-secondary); margin: 0.25rem 0; font-size: 0.875rem;">📧 {{ $invoice->customer_email }}</p>
            @endif
            @if($invoice->customer_phone)
            <p style="color: var(--text-secondary); margin: 0.25rem 0; font-size: 0.875rem;">📞 {{ $invoice->customer_phone }}</p>
            @endif
            @if($invoice->customer_address)
            <p style="color: var(--text-secondary); margin: 0.25rem 0; font-size: 0.875rem;">📍 {{ $invoice->customer_address }}</p>
            @endif
        </div>
    </div>

    <!-- Items Table -->
    <div style="overflow-x: auto; margin-bottom: 2rem;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: var(--table-header-bg); border-bottom: 2px solid var(--border-color);">
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-secondary);">Item</th>
                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text-secondary);">Qty</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-secondary);">Unit Price</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-secondary);">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem;">
                        <div style="font-weight: 500;">{{ $item->item_name }}</div>
                        @if($item->description)
                        <div style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 0.25rem;">{{ $item->description }}</div>
                        @endif
                    </td>
                    <td style="padding: 1rem; text-align: center; color: var(--text-secondary);">{{ number_format($item->quantity, 2) }} {{ $item->unit }}</td>
                    <td style="padding: 1rem; text-align: right; color: var(--text-secondary);">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td style="padding: 1rem; text-align: right; font-weight: 600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total Section -->
    <div style="display: flex; justify-content: flex-end;">
        <div style="min-width: 300px; background-color: var(--table-header-bg); padding: 1.5rem; border-radius: 0.5rem; border: 2px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                <span style="color: var(--text-secondary);">Subtotal:</span>
                <span style="font-weight: 500;">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($invoice->discount_amount > 0)
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                <span style="color: var(--text-secondary);">Discount ({{ $invoice->discount_percentage }}%):</span>
                <span style="font-weight: 500; color: #dc2626;">- Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($invoice->tax_amount > 0)
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                <span style="color: var(--text-secondary);">Tax ({{ $invoice->tax_percentage }}%):</span>
                <span style="font-weight: 500;">Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div style="border-top: 2px solid var(--border-color); padding-top: 0.75rem; margin-top: 0.75rem; display: flex; justify-content: space-between;">
                <span style="font-weight: 700; font-size: 1.125rem;">Total:</span>
                <span style="font-weight: 700; font-size: 1.5rem; color: var(--primary-color);">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @if($invoice->notes)
    <div style="margin-top: 2rem; padding: 1rem; background-color: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 0.375rem;">
        <p style="font-weight: 600; color: #92400e; margin: 0 0 0.5rem 0;">Notes:</p>
        <p style="color: #78350f; margin: 0;">{{ $invoice->notes }}</p>
    </div>
    @endif
</div>
@endsection
