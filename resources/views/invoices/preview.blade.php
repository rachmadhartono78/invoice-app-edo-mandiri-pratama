@extends('layouts.app')

@section('content')
<div class="h-[calc(100vh-100px)] overflow-hidden">
    <!-- Main Container: Flex Row for Desktop -->
    <div class="flex h-full gap-6">
        
        <!-- Left Sidebar: Controls (Fixed Width) -->
        <div class="w-80 flex-shrink-0 flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 h-full">
            
            <!-- Header -->
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Print Settings
                </h2>
            </div>
            
            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6">
                
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

            </div>

             <!-- Footer Actions -->
             <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-lg">
                <div class="flex flex-col gap-3">
                    <a id="downloadBtn" href="#" target="_blank" class="btn btn-primary w-full text-center justify-center flex items-center gap-2 py-2.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </a>
                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-outline w-full text-center justify-center py-2.5">
                        Back to Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Preview Area (Flex Grow) -->
        <div class="flex-1 bg-gray-600 rounded-lg shadow-inner overflow-hidden relative">
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                 <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white opacity-20"></div>
            </div>
            <iframe id="pdfPreview" src="" class="w-full h-full border-none relative z-10 bg-white"></iframe>
        </div>

    </div>
</div>

<script>
    function updatePreview() {
        const template = document.querySelector('input[name="template"]:checked').value;
        const invoiceId = "{{ $invoice->id }}";
        const url = `/invoices/${invoiceId}/stream-pdf?template=${template}`;
        
        document.getElementById('pdfPreview').src = url;
        document.getElementById('downloadBtn').href = url;
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', updatePreview);
</script>
@endsection
