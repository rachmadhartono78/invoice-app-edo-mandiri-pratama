@extends('layouts.app')

@section('content')
<div style="display: flex; height: calc(100vh - 100px); gap: 20px;">
    <!-- Sidebar / Controls -->
    <div style="width: 300px; padding: 20px; background: var(--card-bg, white); border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
        <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 20px; color: var(--text-color);">Print Settings</h2>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 10px; color: var(--text-color);">Select Template</label>
            
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <label style="display: flex; align-items: center; padding: 10px; border: 1px solid var(--border-color, #e5e7eb); border-radius: 6px; cursor: pointer; transition: all 0.2s; background: var(--input-bg, transparent);">
                    <input type="radio" name="template" value="simple" checked onchange="updatePreview()" style="margin-right: 10px;">
                    <div>
                        <div style="font-weight: 600; color: var(--text-color);">Simple</div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary, #6b7280);">Classic Formal Style</div>
                    </div>
                </label>

                <label style="display: flex; align-items: center; padding: 10px; border: 1px solid var(--border-color, #e5e7eb); border-radius: 6px; cursor: pointer; transition: all 0.2s; background: var(--input-bg, transparent);">
                    <input type="radio" name="template" value="modern" onchange="updatePreview()" style="margin-right: 10px;">
                    <div>
                        <div style="font-weight: 600; color: var(--text-color);">Modern</div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary, #6b7280);">Keling Studio Style</div>
                    </div>
                </label>

                <label style="display: flex; align-items: center; padding: 10px; border: 1px solid var(--border-color, #e5e7eb); border-radius: 6px; cursor: pointer; transition: all 0.2s; background: var(--input-bg, transparent);">
                    <input type="radio" name="template" value="business" onchange="updatePreview()" style="margin-right: 10px;">
                    <div>
                        <div style="font-weight: 600; color: var(--text-color);">Business</div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary, #6b7280);">Bold & Professional</div>
                    </div>
                </label>
            </div>
        </div>

        <div style="margin-top: auto; display: flex; flex-direction: column; gap: 10px;">
            <a id="downloadBtn" href="#" target="_blank" class="btn btn-primary" style="text-align: center; justify-content: center;">
                Download PDF
            </a>
            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-outline" style="text-align: center; justify-content: center;">
                Cancel
            </a>
        </div>
    </div>

    <!-- Preview Area -->
    <div style="flex: 1; background: #525659; border-radius: 8px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
        <iframe id="pdfPreview" src="" style="width: 100%; height: 100%; border: none;"></iframe>
    </div>
</div>

<script>
    function updatePreview() {
        const template = document.querySelector('input[name="template"]:checked').value;
        const invoiceId = "{{ $invoice->id }}";
        const url = `/invoices/${invoiceId}/stream-pdf?template=${template}`;
        
        document.getElementById('pdfPreview').src = url;
        document.getElementById('downloadBtn').href = url;
        
        // Update functionality to also support printing directly if desired, 
        // but since it's a PDF stream, browser's native print works best.
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', updatePreview);
</script>
@endsection
