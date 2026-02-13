@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2.5rem;">
    <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0 0 0.5rem 0;">Dashboard</h1>
    <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">Overview of your business performance.</p>
</div>

<style>
    /* Dashboard Stats Grid */
    .stats-grid {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        /* Default: Laptop/Desktop - Force 3 columns if space permits, else wrap gracefully but keep them side-by-side as much as possible */
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    }

    /* Card adjustments */
    .stats-card {
        padding: 1.25rem; /* Slightly smaller padding */
        transition: transform 0.2s;
        height: 100%; /* Ensure equal height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stats-value {
        font-size: 1.75rem; /* Slightly smaller font */
        font-weight: 800;
        margin: 0;
    }

    /* Mobile specific overrides */
    @media (max-width: 768px) {
        .stats-grid {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 1rem; /* Space for scrollbar */
            gap: 1rem;
            margin-right: -1rem; /* Compensate for right padding of container */
            padding-right: 1rem;
        }

        .stats-card {
            min-width: 85vw; /* Show mostly one card with a peek of the next */
            max-width: 300px; /* Don't get too wide on larger phones */
            scroll-snap-align: start;
            flex-shrink: 0;
        }
    }
    
    /* Laptop specific - adjustments if needed */
    @media (min-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr); /* Strictly 3 columns on larger screens */
        }
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    
    <!-- Revenue Card -->
    <div class="card stats-card">
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
            <h3 class="stats-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>
    
    <!-- Pending Invoices Card -->
    <div class="card stats-card">
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
            <h3 class="stats-value">Rp {{ number_format($pendingInvoicesAmount, 0, ',', '.') }}</h3>
        </div>
    </div>
    
    <!-- Clients Card -->
    <div class="card stats-card">
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
            <h3 class="stats-value">{{ $totalClients }}</h3>
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
                        <a href="{{ url('/invoices/' . $invoice->id) }}" 
    title="View Details"
    style="display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; border-radius: 9999px; color: var(--text-secondary); transition: all 0.2s;"
    onmouseover="this.style.backgroundColor='var(--primary-light)'; this.style.color='var(--primary-color)'"
    onmouseout="this.style.backgroundColor=''; this.style.color='var(--text-secondary)'">
    <svg style="width: 1.25rem; height: 1.25rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
    </svg>
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
