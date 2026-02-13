@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0 0 0.5rem 0;">Cetak Invoice</h1>
            <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">Pilih invoice yang ingin Anda cetak sebagai PDF.</p>
        </div>
    </div>
</div>

<!-- Search -->
<div class="card" style="margin-bottom: 2rem;">
    <form method="GET" action="{{ route('invoices.print_page') }}" style="display: flex; gap: 1rem; align-items: center;">
        <div style="flex: 1; position: relative;">
            <div style="position: absolute; inset-y: 0; left: 0; padding-left: 0.75rem; display: flex; align-items: center; pointer-events: none; height: 100%;">
                <svg style="width: 1rem; height: 1rem; color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nomor invoice atau nama pelanggan..." 
                   style="width: 100%; padding: 0.6rem 0.6rem 0.6rem 2.25rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('invoices.print_page') }}" class="btn btn-outline">Reset</a>
        @endif
    </form>
</div>

<div class="card" style="border-radius: 0.75rem; overflow: hidden; padding: 0;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
             <thead style="background: var(--table-header-bg); border-bottom: 1px solid var(--border-color);">
                <tr>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Invoice #</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Pelanggan</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Tanggal</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Total</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.1s;" onmouseover="this.style.backgroundColor='var(--table-row-hover)'" onmouseout="this.style.backgroundColor=''">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; font-size: 0.875rem;">{{ $invoice->invoice_number }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 500; font-size: 0.875rem;">{{ $invoice->customer_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $invoice->customer_email }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: var(--text-secondary);">{{ $invoice->invoice_date->format('d M Y') }}</td>
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
                         <span style="display: inline-block; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; {{ $style }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <a href="{{ route('invoices.preview', $invoice->id) }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print / Preview
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem 2rem; text-align: center; color: var(--text-secondary);">
                        Belum ada invoice untuk ditampilkan.
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
