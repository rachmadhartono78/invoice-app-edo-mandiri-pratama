@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0 0 0.5rem 0;">Clients</h1>
            <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">{{ $totalClients }} total clients</p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Client
        </a>
    </div>
</div>

@if(session('success'))
<div style="background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.375rem;">
    <div style="display: flex; align-items: center; gap: 0.5rem;">
        <svg style="width: 1.25rem; height: 1.25rem; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <p style="color: #065f46; font-weight: 600; margin: 0;">{{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Search -->
<div class="card" style="margin-bottom: 2rem;">
    <form method="GET" action="{{ route('clients.index') }}" style="display: flex; gap: 1rem; align-items: end;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Search</label>
            <div style="position: relative;">
                <div style="position: absolute; inset-y: 0; left: 0; padding-left: 0.75rem; display: flex; align-items: center; pointer-events: none;">
                    <svg style="width: 1rem; height: 1rem; color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by name, email, phone, or company..." 
                       style="width: 100%; padding: 0.6rem 0.6rem 0.6rem 2.25rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        @if(request('search'))
            <a href="{{ route('clients.index') }}" class="btn btn-outline">Clear</a>
        @endif
    </form>
</div>

<!-- Clients List -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: var(--table-header-bg); border-bottom: 1px solid var(--border-color);">
                <tr>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Client</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Contact</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Company</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s;" 
                    onmouseover="this.style.backgroundColor='var(--table-row-hover)'" 
                    onmouseout="this.style.backgroundColor=''">
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; flex-shrink: 0;">
                                {{ strtoupper(substr($client->name, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 0.875rem;">{{ $client->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-size: 0.875rem;">{{ $client->email ?: '-' }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $client->phone ?: '-' }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: var(--text-secondary);">
                        {{ $client->company ?: '-' }}
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                            <a href="{{ route('clients.show', $client) }}" style="font-size: 0.875rem; text-decoration: none; color: var(--text-secondary); font-weight: 500;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color=''">View</a>
                            <a href="{{ route('clients.edit', $client) }}" style="font-size: 0.875rem; text-decoration: none; color: var(--text-secondary); font-weight: 500;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color=''">Edit</a>
                            <form method="POST" action="{{ route('clients.destroy', $client) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this client?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 0.875rem; color: var(--text-secondary); font-weight: 500; font-family: inherit; padding: 0;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color=''">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 4rem 2rem; text-align: center;">
                        <div style="background: var(--table-header-bg); width: 4rem; height: 4rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--text-secondary);">
                            <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">No clients yet</h3>
                        <p style="font-size: 0.875rem; margin-bottom: 1.5rem;">Add your first client to get started.</p>
                        <a href="{{ route('clients.create') }}" class="btn btn-primary">Add Client</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($clients->hasPages())
<div style="margin-top: 2rem;">
    {{ $clients->links() }}
</div>
@endif
@endsection
