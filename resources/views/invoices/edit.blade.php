@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding-bottom: 5rem;">
    <div style="position: sticky; top: 0; z-index: 10; background: var(--bg-color); padding: 1rem 0; border-bottom: 1px solid var(--border-color); margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <span style="color: var(--text-secondary); font-size: 0.875rem;">Editing Invoice</span>
            <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">{{ $invoice->invoice_number }}</h1>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ url('/invoices/' . $invoice->id) }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Cancel</a>
            <button type="button" onclick="document.getElementById('invoice-form').submit()" class="btn btn-primary" style="padding: 0.5rem 1.5rem; font-weight: 600;">
                <svg style="width: 1rem; height: 1rem; margin-right: 0.375rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Update Invoice
            </button>
        </div>
    </div>

    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" id="invoice-form">
        @csrf
        @method('PUT')
        
        <div style="display: grid; gap: 2rem;">
            <section class="card">
                <div style="padding: 1.5rem; background: var(--table-header-bg); border-bottom: 1px solid var(--border-color); margin: -1.5rem -1.5rem 1.5rem -1.5rem; border-radius: 0.5rem 0.5rem 0 0;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Customer Details
                    </h3>
                </div>
                <div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Customer Name <span style="color:#ef4444">*</span></label>
                        <input type="text" name="customer_name" class="form-input" value="{{ old('customer_name', $invoice->customer_name) }}" placeholder="e.g. PT Maju Mundur" style="font-size: 1.1rem; padding: 0.75rem;" required>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--text-secondary);">Phone (Optional)</label>
                            <input type="text" name="customer_phone" class="form-input" value="{{ old('customer_phone', $invoice->customer_phone) }}" placeholder="0812...">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--text-secondary);">Email (Optional)</label>
                            <input type="email" name="customer_email" class="form-input" value="{{ old('customer_email', $invoice->customer_email) }}" placeholder="email@example.com">
                        </div>
                    </div>
                    <div style="margin-top: 1rem;">
                        <label style="display: block; font-weight: 500; font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--text-secondary);">Address (Optional)</label>
                        <textarea name="customer_address" class="form-input" rows="2" placeholder="Jalan...">{{ old('customer_address', $invoice->customer_address) }}</textarea>
                    </div>
                </div>
            </section>

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
                            <label style="display: block; font-weight: 500; font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--text-secondary);">Number</label>
                            <input type="text" name="invoice_number" class="form-input" value="{{ $invoice->invoice_number }}" readonly style="cursor: not-allowed; opacity: 0.7;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--text-secondary);">Date</label>
                            <input type="date" name="invoice_date" class="form-input" value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" required>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--text-secondary);">Due Date</label>
                            <input type="date" name="due_date" class="form-input" value="{{ old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.85rem; margin-bottom: 0.4rem; color: var(--text-secondary);">Status</label>
                            <select name="status" class="form-input">
                                <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card" style="padding: 0;">
                <div style="padding: 1.5rem; background: var(--table-header-bg); border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; border-radius: 0.5rem 0.5rem 0 0;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Products / Items
                    </h3>
                    <button type="button" onclick="addItem()" class="btn btn-primary" style="font-size: 0.9rem; padding: 0.4rem 1rem;">+ Add Item</button>
                </div>
                <div id="items-container" style="padding: 1.5rem;"></div>
                <div id="empty-state" style="padding: 3rem; text-align: center; color: var(--text-secondary); border: 2px dashed var(--border-color); border-radius: 0.5rem; margin: 1.5rem; display: none;">
                    <svg style="width: 3rem; height: 3rem; margin: 0 auto 1rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p style="margin-bottom: 1rem;">No items added yet</p>
                    <button type="button" onclick="addItem()" class="btn btn-outline btn-sm">Add First Item</button>
                </div>
            </section>

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
                            <input type="number" name="discount_percentage" id="discount-input" value="{{ old('discount_percentage', $invoice->discount_percentage) }}" min="0" max="100" class="form-input" style="width: 80px; padding: 0.3rem; text-align: right;" oninput="calculateTotals()">
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                            <span style="color: var(--text-secondary); font-size: 0.9rem;">Tax (%)</span>
                            <input type="number" name="tax_percentage" id="tax-input" value="{{ old('tax_percentage', $invoice->tax_percentage) }}" min="0" max="100" class="form-input" style="width: 80px; padding: 0.3rem; text-align: right;" oninput="calculateTotals()">
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span style="color: var(--text-secondary); font-size: 0.9rem;">Other Charges</span>
                            <input type="number" name="other_charges" id="other-input" value="{{ old('other_charges', $invoice->other_charges) }}" min="0" class="form-input" style="width: 100px; padding: 0.3rem; text-align: right;" oninput="calculateTotals()">
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
                <label style="display: block; font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Additional Notes</label>
                <textarea name="notes" class="form-input" rows="3" placeholder="Payment details, terms, etc...">{{ old('notes', $invoice->notes) }}</textarea>
                <div style="margin-top: 1rem;">
                    <label style="display: block; font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; color: var(--text-secondary);">Payment Terms</label>
                    <textarea name="payment_terms" class="form-input" rows="2" placeholder="e.g. Net 30...">{{ old('payment_terms', $invoice->payment_terms) }}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>

<datalist id="products-list">
    @foreach(\App\Models\Product::all() as $product)
        <option value="{{ $product->name }}" data-price="{{ $product->price }}" data-unit="{{ $product->unit }}">
            {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}/{{ $product->unit }}
        </option>
    @endforeach
</datalist>

<script>
    let itemCount = 0;
    function formatRupiah(amount) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount); }

    function addItem(data = null) {
        document.getElementById('empty-state').style.display = 'none';
        const container = document.getElementById('items-container');
        const div = document.createElement('div');
        div.className = 'item-row';
        div.style.cssText = 'background:var(--card-bg);border:1px solid var(--border-color);border-radius:0.5rem;padding:1.25rem;margin-bottom:1rem;position:relative;box-shadow:0 1px 2px rgba(0,0,0,0.05);transition:all 0.2s;';
        const itemName = data ? data.item_name : '';
        const qty = data ? data.quantity : 1;
        const unit = data ? data.unit : '';
        const price = data ? data.unit_price : '';
        const c = itemCount;
        div.innerHTML = `
            <button type="button" onclick="removeItem(this)" style="position:absolute;top:0.75rem;right:0.75rem;color:var(--text-secondary);background:none;border:none;font-size:1.25rem;cursor:pointer;padding:0.25rem;">&times;</button>
            <div style="margin-bottom:1rem;padding-right:2rem;">
                <label class="item-label">Product Name</label>
                <input type="text" list="products-list" name="items[${c}][product_search]" class="form-input product-search" value="${itemName}" placeholder="Search or type new item..." onchange="fillProduct(this)" style="font-weight:500;" required>
                <input type="hidden" name="items[${c}][item_name]" class="item-name" value="${itemName}">
                <input type="hidden" name="items[${c}][item_code]" value="ITM-${Date.now()}">
            </div>
            <div style="display:grid;grid-template-columns:80px 100px 1fr 1fr;gap:0.75rem;align-items:start;">
                <div><label class="item-label">Qty</label><input type="number" name="items[${c}][quantity]" class="form-input item-qty" value="${qty}" min="0.1" step="any" oninput="calculateRow(this)" required></div>
                <div><label class="item-label">Unit</label><input type="text" name="items[${c}][unit]" class="form-input item-unit" value="${unit}" placeholder="pcs"></div>
                <div style="grid-column:span 2;"><label class="item-label">Price</label><div style="position:relative;"><span style="position:absolute;left:0.75rem;top:0.6rem;color:var(--text-secondary);font-size:0.9rem;">Rp</span><input type="number" name="items[${c}][unit_price]" class="form-input item-price" value="${price}" style="padding-left:2rem;" placeholder="0" step="any" oninput="calculateRow(this)" required></div></div>
            </div>
            <div style="margin-top:1rem;text-align:right;font-weight:600;color:var(--text-secondary);font-size:0.95rem;border-top:1px dashed var(--border-color);padding-top:0.75rem;">Subtotal: <span class="item-total-display">Rp 0</span></div>`;
        container.appendChild(div);
        if(data) calculateRow(div.querySelector('.item-qty'));
        itemCount++;
    }
    function removeItem(btn) { if(confirm('Remove item?')) { btn.closest('.item-row').remove(); if(!document.getElementById('items-container').children.length) document.getElementById('empty-state').style.display='block'; calculateTotals(); } }
    function fillProduct(input) { const val=input.value,list=document.getElementById('products-list'),row=input.closest('.item-row'); row.querySelector('.item-name').value=val; for(let o of list.options) if(o.value===val){row.querySelector('.item-price').value=o.getAttribute('data-price');row.querySelector('.item-unit').value=o.getAttribute('data-unit');calculateRow(input);break;} }
    function calculateRow(el) { const row=el.closest('.item-row'),qty=parseFloat(row.querySelector('.item-qty').value)||0,price=parseFloat(row.querySelector('.item-price').value)||0; row.querySelector('.item-total-display').textContent=formatRupiah(qty*price); calculateTotals(); }
    function calculateTotals() { let s=0; document.querySelectorAll('.item-row').forEach(r=>{s+=(parseFloat(r.querySelector('.item-qty').value)||0)*(parseFloat(r.querySelector('.item-price').value)||0);}); const d=parseFloat(document.getElementById('discount-input').value)||0,t=parseFloat(document.getElementById('tax-input').value)||0,o=parseFloat(document.getElementById('other-input').value)||0,da=s*(d/100),sa=s-da,ta=sa*(t/100),tot=sa+ta+o; document.getElementById('subtotal-display').textContent=formatRupiah(s); document.getElementById('subtotal-input').value=s; document.getElementById('total-display').textContent=formatRupiah(tot); document.getElementById('total-input').value=tot; }
    document.addEventListener('DOMContentLoaded', () => { const items=@json($invoice->items); if(items.length>0) items.forEach(i=>addItem(i)); else addItem(); calculateTotals(); });
</script>
<style>
    .form-input { width:100%; padding:0.6rem 0.8rem; border:1px solid var(--input-border); border-radius:0.375rem; transition:border-color 0.2s,box-shadow 0.2s; font-size:0.95rem; background-color:var(--input-bg); color:var(--text-color); }
    .form-input:focus { border-color:var(--primary-color); outline:none; box-shadow:0 0 0 3px rgba(79,70,229,0.1); }
    .item-label { display:block; font-size:0.8rem; font-weight:500; color:var(--text-secondary); margin-bottom:0.25rem; }
    @media (max-width:640px) { .item-row div[style*="grid-template-columns"]{grid-template-columns:1fr 1fr!important;} .item-row div[style*="grid-column: span 2"]{grid-column:span 2!important;} }
</style>
@endsection
