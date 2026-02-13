@extends('layouts.app')

@section('content')
<div class="flex flex-col lg:flex-row h-auto lg:h-[calc(100vh-100px)] gap-6">
    <!-- Sidebar / Controls -->
    <div class="w-full lg:w-[300px] p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm flex flex-col h-auto lg:h-full order-1 lg:order-none">
        <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">Print Settings</h2>
        
        <div class="mb-6">
            <label class="block font-semibold mb-3 text-gray-700 dark:text-gray-300">Select Template</label>
            
            <div class="flex flex-col gap-3">
                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                    <input type="radio" name="template" value="simple" checked onchange="updatePreview()" class="mr-3 text-blue-600 focus:ring-blue-500">
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-white group-hover:text-blue-600 transition-colors">Simple</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Classic Formal Style</div>
                    </div>
                </label>

                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                    <input type="radio" name="template" value="modern" onchange="updatePreview()" class="mr-3 text-blue-600 focus:ring-blue-500">
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-white group-hover:text-blue-600 transition-colors">Modern</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Keling Studio Style</div>
                    </div>
                </label>

                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                    <input type="radio" name="template" value="business" onchange="updatePreview()" class="mr-3 text-blue-600 focus:ring-blue-500">
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-white group-hover:text-blue-600 transition-colors">Business</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Bold & Professional</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="mt-auto flex flex-col gap-3">
            <a id="downloadBtn" href="#" target="_blank" class="btn btn-primary w-full text-center justify-center">
                Download PDF
            </a>
            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-outline w-full text-center justify-center">
                Cancel
            </a>
        </div>
    </div>

    <!-- Preview Area -->
    <div class="w-full lg:flex-1 bg-gray-600 rounded-lg overflow-hidden flex justify-center items-center h-[500px] lg:h-full shadow-inner order-2 lg:order-none">
        <iframe id="pdfPreview" src="" class="w-full h-full border-none"></iframe>
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
