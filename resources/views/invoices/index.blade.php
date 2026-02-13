@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0 0 0.5rem 0;">Invoices</h1>
            <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">Manage and track all your invoices.</p>
        </div>
        <a href="{{ url('/invoices/create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Invoice
        </a>
    </div>
</div>

@if(session('success'))
<div style="background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
    <div style="display: flex; align-items: center; gap: 0.5rem;">
        <svg style="width: 1.25rem; height: 1.25rem; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <p style="color: #065f46; font-weight: 600; margin: 0;">{{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Search and Filter -->
<div class="card" style="margin-bottom: 2rem;">
    <form method="GET" action="{{ route('invoices.index') }}" style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Search</label>
            <div style="position: relative;">
                <div style="position: absolute; inset-y: 0; left: 0; padding-left: 0.75rem; display: flex; align-items: center; pointer-events: none;">
                    <svg style="width: 1rem; height: 1rem; color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Filter by invoice #, customer..." 
                       style="width: 100%; padding: 0.6rem 0.6rem 0.6rem 2.25rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
            </div>
        </div>
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Status</label>
            <select name="status" style="padding: 0.6rem; border: 1px solid var(--input-border); border-radius: 0.375rem; min-width: 150px; font-size: 0.95rem; background-color: var(--input-bg); color: var(--text-color);">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="white-space: nowrap;">
                Apply
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('invoices.index') }}" class="btn btn-outline" style="white-space: nowrap;">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

<div class="card" style="border-radius: 0.75rem; overflow: hidden; padding: 0;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
             <thead style="background: var(--table-header-bg); border-bottom: 1px solid var(--border-color);">
                <tr>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Invoice</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Client</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Date</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Amount</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease-in-out;" 
                    onmouseover="this.style.backgroundColor='var(--table-row-hover)'" 
                    onmouseout="this.style.backgroundColor=''">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; font-size: 0.875rem;">
                        {{ $invoice->invoice_number }}
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 500; font-size: 0.875rem;">{{ $invoice->customer_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $invoice->customer_email }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: var(--text-secondary);">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                    <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 600; font-size: 0.875rem;">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                         @php
                            $statusStyles = [
                                'paid' => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                                'pending' => 'background-color: #fff7ed; color: #9a3412; border: 1px solid #fed7aa;',
                                'overdue' => 'background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca;',
                                'cancelled' => 'background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;',
                                'draft' => 'background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;'
                            ];
                            $style = $statusStyles[$invoice->status] ?? $statusStyles['draft'];
                        @endphp
                         <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; {{ $style }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <a href="{{ url('/invoices/' . $invoice->id) }}" 
                           style="color: var(--text-secondary); text-decoration: none; font-weight: 500; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: color 0.1s;"
                           onmouseover="this.style.color='var(--primary-color)'"
                           onmouseout="this.style.color=''">
                            View <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem 2rem; text-align: center;">
                         <div style="background: var(--table-header-bg); width: 4rem; height: 4rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--text-secondary);">
                            <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">No invoices found</h3>
                        <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1.5rem;">
                            @if(request('search') || request('status'))
                                No results match your filters.
                            @else
                                Start by creating your first invoice.
                            @endif
                        </p>
                        @if(!request('search') && !request('status'))
                            <a href="{{ route('invoices.create') }}" class="btn btn-primary" style="font-size: 0.875rem;">Create Invoice</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($invoices->hasPages())
<div style="margin-top: 2rem;">
    {{ $invoices->links() }}
</div>
@endif

@endsection
