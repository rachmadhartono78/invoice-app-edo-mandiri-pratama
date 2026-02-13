@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <a href="{{ route('products.index') }}" style="color: var(--text-secondary); text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.875rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color=''">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Products
            </a>
        </div>
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0;">Add New Product</h1>
        <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0; font-size: 0.95rem;">Fill in the details below to add a new product to your catalog.</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <!-- Product Information -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div style="padding: 1.25rem 1.5rem; background: var(--table-header-bg); border-bottom: 1px solid var(--border-color); margin: -1.5rem -1.5rem 1.5rem -1.5rem; border-radius: 0.5rem 0.5rem 0 0;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Product Information
                </h3>
            </div>

            <div style="display: grid; gap: 1.5rem;">
                <!-- Name -->
                <div>
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary);">Product Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 1rem; background: var(--input-bg); color: var(--text-color); transition: border-color 0.2s, box-shadow 0.2s;"
                           placeholder="e.g., Timbangan 150kg"
                           onfocus="this.style.borderColor='var(--primary-color)';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                           onblur="this.style.borderColor='';this.style.boxShadow=''">
                    @error('name') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
                </div>

                <!-- Category & Unit (side by side) -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                    <div>
                        <label for="category" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary);">Category</label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}"
                               style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color); transition: border-color 0.2s, box-shadow 0.2s;"
                               placeholder="e.g., AREA MASAK"
                               onfocus="this.style.borderColor='var(--primary-color)';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''">
                        @error('category') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="unit" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary);">Unit <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="unit" name="unit" value="{{ old('unit', 'unit') }}" required
                               style="width: 100%; padding: 0.625rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color); transition: border-color 0.2s, box-shadow 0.2s;"
                               placeholder="e.g., pcs, kg, set"
                               onfocus="this.style.borderColor='var(--primary-color)';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''">
                        @error('unit') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing & Details -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div style="padding: 1.25rem 1.5rem; background: var(--table-header-bg); border-bottom: 1px solid var(--border-color); margin: -1.5rem -1.5rem 1.5rem -1.5rem; border-radius: 0.5rem 0.5rem 0 0;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pricing & Details
                </h3>
            </div>

            <div style="display: grid; gap: 1.5rem;">
                <!-- Price -->
                <div>
                    <label for="price" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary);">Price <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-weight: 500; font-size: 0.9rem; pointer-events: none;">Rp</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="any" required
                               style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.25rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 1.1rem; font-weight: 600; background: var(--input-bg); color: var(--text-color); transition: border-color 0.2s, box-shadow 0.2s;"
                               placeholder="0"
                               onfocus="this.style.borderColor='var(--primary-color)';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                               onblur="this.style.borderColor='';this.style.boxShadow=''">
                    </div>
                    @error('price') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary);">Description / Dimensions</label>
                    <textarea id="description" name="description" rows="4"
                              style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border); border-radius: 0.375rem; font-size: 0.95rem; resize: vertical; background: var(--input-bg); color: var(--text-color); font-family: inherit; transition: border-color 0.2s, box-shadow 0.2s; line-height: 1.5;"
                              placeholder="e.g., 1500x600x850 mm&#10;Material: Stainless Steel&#10;Weight: 25kg"
                              onfocus="this.style.borderColor='var(--primary-color)';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                              onblur="this.style.borderColor='';this.style.boxShadow=''">{{ old('description') }}</textarea>
                    @error('description') <p style="color: #ef4444; font-size: 0.8rem; margin: 0.25rem 0 0 0;">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; padding-top: 0.5rem;">
            <a href="{{ route('products.index') }}" class="btn btn-outline" style="padding: 0.625rem 1.25rem;">Cancel</a>
            <button type="submit" class="btn btn-primary" style="padding: 0.625rem 2rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                <svg style="width: 1rem; height: 1rem; margin-right: 0.375rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection
