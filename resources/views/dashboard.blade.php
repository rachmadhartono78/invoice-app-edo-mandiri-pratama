@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2.5rem;">
    <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0 0 0.5rem 0;">Dashboard</h1>
    <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">Overview of your business performance.</p>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    
    <!-- Revenue Card -->
    <div class="card" style="padding: 1.5rem; transition: transform 0.2s;">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
            <div style="width: 3rem; height: 3rem; background-color: var(--primary-light); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                <!-- Trending Up Icon -->
                <x-icons.dashboard class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" />
            </div>
             <!-- Trend Indicator -->
            @if($revenueGrowth != 0)
                <span style="background-color: {{ $revenueGrowth > 0 ? '#ecfdf5' : '#fef2f2' }}; color: {{ $revenueGrowth > 0 ? '#065f46' : '#991b1b' }}; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem;">
                    @if($revenueGrowth > 0)
                        <svg style="width: 0.75rem; height: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        +{{ number_format(abs($revenueGrowth), 1) }}%
                    @else
                        <svg style="width: 0.75rem; height: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                        -{{ number_format(abs($revenueGrowth), 1) }}%
                    @endif
                </span>
            @else
                 <span style="background-color: #f3f4f6; color: #374151; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                    0%
                </span>
            @endif
        </div>
        <div>
            <p style="color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">Total Revenue</p>
            <h3 style="font-size: 2rem; font-weight: 800; margin: 0;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>
    
    <!-- Pending Invoices Card -->
    <div class="card" style="padding: 1.5rem; transition: transform 0.2s;">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
            <div style="width: 3rem; height: 3rem; background-color: #fff7ed; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #f97316;">
                <!-- Clock / Hourglass Icon -->
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
             <span style="background-color: #eff6ff; color: #1e40af; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                {{ $pendingInvoicesCount }} Pending
            </span>
        </div>
        <div>
            <p style="color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">Outstanding Amount</p>
            <h3 style="font-size: 2rem; font-weight: 800; margin: 0;">Rp {{ number_format($pendingInvoicesAmount, 0, ',', '.') }}</h3>
        </div>
    </div>
    
    <!-- Clients Card -->
    <div class="card" style="padding: 1.5rem; transition: transform 0.2s;">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
            <div style="width: 3rem; height: 3rem; background-color: #f0fdf4; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #16a34a;">
                <!-- Users Group Icon -->
                <x-icons.clients class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" />
            </div>
             <span style="background-color: #ecfdf5; color: #065f46; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                Active
            </span>
        </div>
        <div>
            <p style="color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">Total Clients</p>
            <h3 style="font-size: 2rem; font-weight: 800; margin: 0;">{{ $totalClients }}</h3>
        </div>
    </div>
</div>

<div class="card" style="border-radius: 0.75rem; overflow: hidden; padding: 0;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Recent Invoices</h3>
            <p style="font-size: 0.875rem; color: var(--text-secondary); margin: 0.25rem 0 0 0;">Latest billing activity</p>
        </div>
        <a href="{{ url('/invoices/create') }}" class="btn btn-primary" style="font-size: 0.875rem;">
            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Invoice
        </a>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: var(--table-header-bg);">
                <tr>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Invoice</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Client</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Date</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Amount</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 0.75rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentInvoices as $invoice)
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
                    <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: var(--text-secondary);">
                        {{ $invoice->invoice_date->format('M d, Y') }}
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 600; font-size: 0.875rem;">
                        Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                         @php
                            $statusStyles = [
                                'paid' => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                                'pending' => 'background-color: #fff7ed; color: #9a3412; border: 1px solid #fed7aa;',
                                'overdue' => 'background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca;',
                                'draft' => 'background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;'
                            ];
                            $style = $statusStyles[$invoice->status] ?? $statusStyles['draft'];
                        @endphp
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; {{ $style }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <a href="{{ url('/invoices/' . $invoice->id) }}" style="color: var(--text-secondary); text-decoration: none; font-weight: 500; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: color 0.1s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color=''">
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
                        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">No invoices generated yet</h3>
                        <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1.5rem;">Get started by creating your first invoice.</p>
                        <a href="{{ url('/invoices/create') }}" class="btn btn-primary" style="font-size: 0.875rem;">Create Invoice</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($recentInvoices->count() > 0)
    <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); background: var(--table-header-bg); text-align: right;">
        <a href="{{ url('/invoices') }}" style="color: var(--primary-color); font-weight: 600; font-size: 0.875rem; text-decoration: none;">View All Invoices &rarr;</a>
    </div>
    @endif
</div>
@endsection
