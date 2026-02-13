@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0 0 0.5rem 0;">Products</h1>
            <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">Manage your product catalog and pricing</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Product
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; background-color: var(--primary-light); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">Total Products</p>
                <h3 style="font-size: 1.75rem; font-weight: 800; margin: 0;">{{ $products->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; background-color: #fef3c7; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #d97706;">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path></svg>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">Categories</p>
                <h3 style="font-size: 1.75rem; font-weight: 800; margin: 0;">{{ \App\Models\Product::distinct('category')->count('category') }}</h3>
            </div>
        </div>
    </div>
    <div class="card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; background-color: #ecfdf5; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #16a34a;">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">Avg. Price</p>
                <h3 style="font-size: 1.75rem; font-weight: 800; margin: 0;">Rp {{ number_format(\App\Models\Product::avg('price'), 0, ',', '.') }}</h3>
            </div>
        </div>
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
    <form method="GET" action="{{ route('products.index') }}" style="display: flex; gap: 1rem; align-items: end;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.875rem;">Search</label>
            <div style="position: relative;">
                <div style="position: absolute; inset-y: 0; left: 0; padding-left: 0.75rem; display: flex; align-items: center; pointer-events: none;">
                    <svg style="width: 1rem; height: 1rem; color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by name or category..." 
                       style="width: 100%; padding: 0.6rem 0.6rem 0.6rem 2.25rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color);">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        @if(request('search'))
            <a href="{{ route('products.index') }}" class="btn btn-outline">Clear</a>
        @endif
    </form>
</div>

<!-- Products Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: var(--table-header-bg); border-bottom: 1px solid var(--border-color);">
                <tr>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Product</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Category</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Price</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Unit</th>
                    <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s;"
                    onmouseover="this.style.backgroundColor='var(--table-row-hover)'"
                    onmouseout="this.style.backgroundColor=''">
                    <td style="padding: 1rem 1.5rem;">
                        <div>
                            <div style="font-weight: 600; font-size: 0.875rem;">{{ $product->name }}</div>
                            @if($product->description)
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.125rem;">{{ Str::limit($product->description, 50) }}</div>
                            @endif
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; background-color: var(--primary-light); color: var(--primary-color); border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                            {{ $product->category ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 600; font-size: 0.875rem;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center; font-size: 0.875rem; color: var(--text-secondary);">
                        {{ $product->unit }}
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('products.edit', $product) }}" title="Edit Product" style="display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; border-radius: 0.375rem; background-color: #eff6ff; color: #3b82f6; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#dbeafe'; this.style.color='#2563eb'" onmouseout="this.style.backgroundColor='#eff6ff'; this.style.color='#3b82f6'">
                                <svg style="width: 1.1rem; height: 1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Delete {{ addslashes($product->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete Product" style="display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; border-radius: 0.375rem; background-color: #fef2f2; color: #ef4444; border: none; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#dc2626'" onmouseout="this.style.backgroundColor='#fef2f2'; this.style.color='#ef4444'">
                                    <svg style="width: 1.1rem; height: 1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem 2rem; text-align: center;">
                        <div style="background: var(--table-header-bg); width: 4rem; height: 4rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--text-secondary);">
                            <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">No products found</h3>
                        <p style="font-size: 0.875rem; margin-bottom: 1.5rem;">
                            @if(request('search'))
                                Try adjusting your search or <a href="{{ route('products.index') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">clear filters</a>
                            @else
                                Add your first product to get started.
                            @endif
                        </p>
                        @if(!request('search'))
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($products->hasPages())
<div style="margin-top: 2rem;">
    {{ $products->links() }}
</div>
@endif
@endsection
