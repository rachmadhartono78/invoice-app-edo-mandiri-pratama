@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
        <a href="{{ route('clients.show', $client) }}" style="color: var(--text-secondary); text-decoration: none; display: flex; align-items: center; gap: 0.25rem; font-size: 0.875rem; font-weight: 500;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color=''">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Client
        </a>
    </div>
    <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0;">Edit Client</h1>
</div>

<div class="card" style="max-width: 700px;">
    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; gap: 1.5rem;">
            <!-- Name -->
            <div>
                <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Name <span style="color: #ef4444;">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}" required
                       style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
                @error('name') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <!-- Email & Phone -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}"
                           style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
                    @error('email') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $client->phone) }}"
                           style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
                    @error('phone') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Company -->
            <div>
                <label for="company" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Company</label>
                <input type="text" id="company" name="company" value="{{ old('company', $client->company) }}"
                       style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
                @error('company') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Address</label>
                <textarea id="address" name="address" rows="3"
                          style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; resize: vertical; background: var(--input-bg); color: var(--text-color);">{{ old('address', $client->address) }}</textarea>
                @error('address') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Notes</label>
                <textarea id="notes" name="notes" rows="2"
                          style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; resize: vertical; background: var(--input-bg); color: var(--text-color);">{{ old('notes', $client->notes) }}</textarea>
            </div>
        </div>

        <div style="display: flex; gap: 0.75rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
            <button type="submit" class="btn btn-primary" style="padding: 0.625rem 1.5rem;">Update Client</button>
            <a href="{{ route('clients.show', $client) }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
