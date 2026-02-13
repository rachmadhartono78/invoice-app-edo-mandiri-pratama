@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
        <a href="{{ route('clients.index') }}" style="color: var(--text-secondary); text-decoration: none; display: flex; align-items: center; gap: 0.25rem; font-size: 0.875rem; font-weight: 500;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color=''">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Clients
        </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: start;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 4rem; height: 4rem; border-radius: 50%; background: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; flex-shrink: 0;">
                {{ strtoupper(substr($client->name, 0, 2)) }}
            </div>
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0;">{{ $client->name }}</h1>
                <p style="color: var(--text-secondary); margin: 0.25rem 0 0 0; font-size: 0.95rem;">{{ $client->company ?: 'Individual' }}</p>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.375rem;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="color: #ef4444; border-color: #fecaca; display: inline-flex; align-items: center; gap: 0.375rem;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div style="background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.375rem;">
    <p style="color: #065f46; font-weight: 600; margin: 0;">✓ {{ session('success') }}</p>
</div>
@endif

<!-- Client Info -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="padding: 1.25rem;">
        <p style="color: var(--text-secondary); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0;">Email</p>
        <p style="font-weight: 500; margin: 0; font-size: 0.95rem;">{{ $client->email ?: 'Not provided' }}</p>
    </div>
    <div class="card" style="padding: 1.25rem;">
        <p style="color: var(--text-secondary); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0;">Phone</p>
        <p style="font-weight: 500; margin: 0; font-size: 0.95rem;">{{ $client->phone ?: 'Not provided' }}</p>
    </div>
    <div class="card" style="padding: 1.25rem;">
        <p style="color: var(--text-secondary); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0;">Company</p>
        <p style="font-weight: 500; margin: 0; font-size: 0.95rem;">{{ $client->company ?: 'Individual' }}</p>
    </div>
</div>

@if($client->address)
<div class="card" style="margin-bottom: 2rem;">
    <p style="color: var(--text-secondary); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0;">Address</p>
    <p style="margin: 0; line-height: 1.6; font-size: 0.95rem;">{{ $client->address }}</p>
</div>
@endif

@if($client->notes)
<div class="card" style="margin-bottom: 2rem;">
    <p style="color: var(--text-secondary); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0;">Notes</p>
    <p style="margin: 0; line-height: 1.6; font-size: 0.95rem; color: var(--text-secondary);">{{ $client->notes }}</p>
</div>
@endif

<div style="margin-top: 2rem; padding: 1.5rem; background: var(--table-header-bg); border-radius: 0.5rem; text-align: center;">
    <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">
        Client added {{ $client->created_at->diffForHumans() }} · Last updated {{ $client->updated_at->diffForHumans() }}
    </p>
</div>
@endsection
