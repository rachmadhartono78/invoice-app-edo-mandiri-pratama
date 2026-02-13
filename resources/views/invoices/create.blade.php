@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding-bottom: 5rem;">
    <!-- Top Bar with Actions -->
    <div style="position: sticky; top: 0; z-index: 10; background: var(--bg-color); padding: 1rem 0; border-bottom: 1px solid var(--border-color); margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em; margin: 0;">New Invoice</h1>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ url('/invoices') }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Cancel</a>
            <button type="button" onclick="document.getElementById('invoice-form').submit()" class="btn btn-primary" style="padding: 0.5rem 1.5rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                <svg style="width: 1rem; height: 1rem; margin-right: 0.375rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Save
            </button>
        </div>
    </div>

    <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
        @csrf
        
        <div style="display: grid; gap: 2rem;">
            <!-- 1. Who is this for? -->
            <section class="card">
                <div style="padding: 1.5rem; background: var(--table-header-bg); border-bottom: 1px solid var(--border-color); margin: -1.5rem -1.5rem 1.5rem -1.5rem; border-radius: 0.5rem 0.5rem 0 0;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Customer Details
                    </h3>
                </div>
                <div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Customer Name <span style="color:#ef4444">*</span></label>
                        <input type="text" name="customer_name" class="form-input" placeholder="e.g. PT Maju Mundur" style="font-size: 0.95rem; padding: 0.6rem 0.8rem;" required>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Phone (Optional)</label>
                            <input type="text" name="customer_phone" class="form-input" placeholder="0812...">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Email (Optional)</label>
                            <input type="email" name="customer_email" class="form-input" placeholder="email@example.com">
                        </div>
                    </div>
                    
                    <div style="margin-top: 1rem;">
                         <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Address (Optional)</label>
                        <textarea name="customer_address" class="form-input" rows="2" placeholder="Jalan..."></textarea>
                    </div>
                </div>
            </section>

            <!-- 2. Invoice Info -->
            <section class="card">
                <div style="padding: 1.5rem; background: var(--table-header-bg); border-bottom: 1px solid var(--border-color); margin: -1.5rem -1.5rem 1.5rem -1.5rem; border-radius: 0.5rem 0.5rem 0 0;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Invoice Info
                    </h3>
                </div>
                <div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Number</label>
                            <input type="text" name="invoice_number" class="form-input" value="{{ $newInvoiceNumber }}" readonly style="cursor: not-allowed; opacity: 0.7; font-weight: bold; color: var(--primary-color);">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Date</label>
                            <input type="date" name="invoice_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Due Date</label>
                            <input type="date" name="due_date" class="form-input">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Status</label>
                            <select name="status" class="form-input">
                                <option value="pending" selected>Pending</option>
                                <option value="paid">Paid</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Items -->
            <section class="card" style="padding: 0;">
                <div style="padding: 1.5rem; background: var(--table-header-bg); border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; border-radius: 0.5rem 0.5rem 0 0;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Products / Items
                    </h3>
                    <button type="button" onclick="addItem()" class="btn btn-primary" style="font-size: 0.9rem; padding: 0.4rem 1rem;">+ Add Item</button>
                </div>
                
                <div id="items-container" style="padding: 1.5rem;">
                    <!-- Items go here -->
                </div>
                
                <div id="empty-state" style="padding: 3rem; text-align: center; color: var(--text-secondary); border: 2px dashed var(--border-color); border-radius: 0.5rem; margin: 1.5rem;">
                    <svg style="width: 3rem; height: 3rem; margin: 0 auto 1rem; color: var(--text-secondary); opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p style="margin-bottom: 1rem;">No items added yet</p>
                    <button type="button" onclick="addItem()" class="btn btn-outline btn-sm">Add First Item</button>
                </div>
            </section>

            <!-- 4. Totals -->
            <section class="card" style="background: var(--table-header-bg);">
                <div style="padding: 0.5rem;">
                    <div style="max-width: 400px; margin-left: auto;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.95rem;">
                            <span style="color: var(--text-secondary);">Subtotal</span>
                            <span style="font-weight: 600;" id="subtotal-display">Rp 0</span>
                            <input type="hidden" name="subtotal" id="subtotal-input" value="0">
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                            <span style="color: var(--text-secondary); font-size: 0.9rem;">Discount (%)</span>
                            <input type="number" name="discount_percentage" id="discount-input" value="0" min="0" max="100" class="form-input" style="width: 80px; padding: 0.3rem; text-align: right;" oninput="calculateTotals()">
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                            <span style="color: var(--text-secondary); font-size: 0.9rem;">Tax (%)</span>
                            <input type="number" name="tax_percentage" id="tax-input" value="0" min="0" max="100" class="form-input" style="width: 80px; padding: 0.3rem; text-align: right;" oninput="calculateTotals()">
                        </div>

                         <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span style="color: var(--text-secondary); font-size: 0.9rem;">Other Charges</span>
                            <input type="number" name="other_charges" id="other-input" value="0" min="0" class="form-input" style="width: 100px; padding: 0.3rem; text-align: right;" oninput="calculateTotals()">
                        </div>

                        <div style="border-top: 2px solid var(--border-color); padding-top: 1rem; margin-top: 1rem; display: flex; justify-content: space-between; align-items: flex-end;">
                            <span style="font-weight: 700; font-size: 1.2rem;">Total</span>
                            <span style="font-weight: 800; font-size: 1.8rem; color: var(--primary-color);" id="total-display">Rp 0</span>
                            <input type="hidden" name="total_amount" id="total-input" value="0">
                        </div>
                    </div>
                </div>
            </section>
            
            <div style="margin-top: 2rem;">
                 <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Additional Notes</label>
                <textarea name="notes" class="form-input" rows="3" placeholder="Payment details, terms, etc..."></textarea>
            </div>
        </div>
    </form>
</div>

<!-- Products Datalist -->
<datalist id="products-list">
    @foreach(\App\Models\Product::all() as $product)
        <option value="{{ $product->name }}" 
                data-price="{{ $product->price }}" 
                data-unit="{{ $product->unit }}">
            {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}/{{ $product->unit }}
        </option>
    @endforeach
</datalist>

<script>
    let itemCount = 0;

    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function addItem() {
        document.getElementById('empty-state').style.display = 'none';
        
        const container = document.getElementById('items-container');
        const div = document.createElement('div');
        div.className = 'item-row';
        div.style.cssText = `
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
            position: relative;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: all 0.2s;
        `;
        
        div.innerHTML = `
            <button type="button" onclick="removeItem(this)" style="position: absolute; top: 0.75rem; right: 0.75rem; color: var(--text-secondary); background: none; border: none; font-size: 1.25rem; line-height: 1; cursor: pointer; padding: 0.25rem;">&times;</button>
            
            <div style="margin-bottom: 1rem; padding-right: 2rem;">
                <label class="item-label">Product Name</label>
                <input type="text" list="products-list" name="items[${itemCount}][product_search]" 
                       class="form-input product-search" 
                       placeholder="Search or type new item..." 
                       onchange="fillProduct(this)" 
                       style="font-weight: 500;"
                       required>
                <input type="hidden" name="items[${itemCount}][item_name]" class="item-name">
                <input type="hidden" name="items[${itemCount}][item_code]" value="ITM-${Date.now()}">
            </div>
            
            <div style="display: grid; grid-template-columns: 80px 100px 1fr 1fr; gap: 0.75rem; align-items: start;">
                 <div>
                    <label class="item-label">Qty</label>
                    <input type="number" name="items[${itemCount}][quantity]" 
                           class="form-input item-qty" 
                           value="1" min="0.1" step="any" 
                           oninput="calculateRow(this)" required>
                </div>
                <div>
                     <label class="item-label">Unit</label>
                    <input type="text" name="items[${itemCount}][unit]" 
                           class="form-input item-unit" 
                           placeholder="pcs">
                </div>
                 <div style="grid-column: span 2;">
                    <label class="item-label">Price</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 0.75rem; top: 0.6rem; color: var(--text-secondary); font-size: 0.9rem;">Rp</span>
                        <input type="number" name="items[${itemCount}][unit_price]" 
                               class="form-input item-price" 
                               style="padding-left: 2rem;"
                               placeholder="0" step="any" 
                               oninput="calculateRow(this)" required>
                    </div>
                </div>
            </div>
            
             <div style="margin-top: 1rem; text-align: right; font-weight: 600; color: var(--text-secondary); font-size: 0.95rem; border-top: 1px dashed var(--border-color); padding-top: 0.75rem;">
                Subtotal: <span class="item-total-display">Rp 0</span>
            </div>
        `;
        
        container.appendChild(div);
        itemCount++;
        
        // Focus on the new input
        div.querySelector('.product-search').focus();
    }

    function removeItem(btn) {
        if(confirm('Remove item?')) {
            btn.closest('.item-row').remove();
            if(document.getElementById('items-container').children.length === 0) {
                document.getElementById('empty-state').style.display = 'block';
            }
            calculateTotals();
        }
    }

    function fillProduct(input) {
        const val = input.value;
        const list = document.getElementById('products-list');
        const row = input.closest('.item-row');
        
        // Set hidden item name
        row.querySelector('.item-name').value = val;

        // Find matched product
        for(let option of list.options) {
            if(option.value === val) {
                row.querySelector('.item-price').value = option.getAttribute('data-price');
                row.querySelector('.item-unit').value = option.getAttribute('data-unit');
                calculateRow(input);
                break;
            }
        }
    }

    function calculateRow(el) {
        const row = el.closest('.item-row');
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const total = qty * price;
        
        row.querySelector('.item-total-display').textContent = formatRupiah(total);
        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            subtotal += qty * price;
        });

        const discountPct = parseFloat(document.getElementById('discount-input').value) || 0;
        const taxPct = parseFloat(document.getElementById('tax-input').value) || 0;
        const other = parseFloat(document.getElementById('other-input').value) || 0;

        const discountAmt = subtotal * (discountPct / 100);
        const subAfterDisc = subtotal - discountAmt;
        const taxAmt = subAfterDisc * (taxPct / 100);
        const total = subAfterDisc + taxAmt + other;

        document.getElementById('subtotal-display').textContent = formatRupiah(subtotal);
        document.getElementById('subtotal-input').value = subtotal;
        document.getElementById('total-display').textContent = formatRupiah(total);
        document.getElementById('total-input').value = total;
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => addItem());
</script>

<style>
    .form-input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 1px solid var(--input-border);
        border-radius: 0.375rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-size: 0.95rem;
        background-color: var(--input-bg);
        color: var(--text-color);
    }
    .form-input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .item-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }
    
    /* Mobile optimization */
    @media (max-width: 640px) {
        .item-row div[style*="grid-template-columns"] {
            grid-template-columns: 1fr 1fr !important; /* Stack columns on very small screens */
        }
        .item-row div[style*="grid-column: span 2"] {
             grid-column: span 2 !important;
        }
    }
</style>
@endsection
