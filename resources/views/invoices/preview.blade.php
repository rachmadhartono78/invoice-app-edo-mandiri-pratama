@extends('layouts.app')

@section('content')
<div class="max-w-[1600px] mx-auto">
    <!-- Mobile/Tablet Tab Navigation -->
    <div class="md:hidden flex bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-4 overflow-hidden border border-gray-200 dark:border-gray-700">
        <button onclick="switchPreviewTab('preview')" id="tab-preview" class="flex-1 py-3 text-sm font-semibold text-center transition-colors bg-blue-50 text-blue-600 border-b-2 border-blue-600">
            Preview PDF
        </button>
        <button onclick="switchPreviewTab('settings')" id="tab-settings" class="flex-1 py-3 text-sm font-semibold text-center transition-colors text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
            Settings
        </button>
    </div>

    <div class="flex flex-col md:flex-row h-auto md:h-[calc(100vh-120px)] gap-6">
        <!-- Sidebar / Controls -->
        <!-- Hidden on mobile by default (controlled by JS), Block on desktop -->
        <div id="settings-panel" class="hidden md:flex w-full md:w-[300px] md:flex-shrink-0 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm flex-col h-auto md:h-full overflow-y-auto">
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Print Settings
            </h2>
            
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
                <a id="downloadBtn" href="#" target="_blank" class="btn btn-primary w-full text-center justify-center flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download PDF
                </a>
                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-outline w-full text-center justify-center">
                    Back to Details
                </a>
            </div>
        </div>

        <!-- Preview Area -->
        <!-- Shown on mobile by default, Block on desktop -->
        <div id="preview-panel" class="flex md:flex-1 bg-gray-600 rounded-lg overflow-hidden justify-center items-center h-[70vh] md:h-full shadow-inner relative">
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
        
        const iframe = document.getElementById('pdfPreview');
        iframe.src = url;
        
        document.getElementById('downloadBtn').href = url;
    }

    function switchPreviewTab(tab) {
        // Mobile Logic Only
        const previewPanel = document.getElementById('preview-panel');
        const settingsPanel = document.getElementById('settings-panel');
        const tabPreview = document.getElementById('tab-preview');
        const tabSettings = document.getElementById('tab-settings');

        // Reset Styles
        const activeClass = ['bg-blue-50', 'text-blue-600', 'border-b-2', 'border-blue-600'];
        const inactiveClass = ['text-gray-600', 'dark:text-gray-400', 'hover:bg-gray-50', 'dark:hover:bg-gray-700'];

        if (tab === 'preview') {
            // Show Preview
            previewPanel.classList.remove('hidden');
            previewPanel.classList.add('flex');
            settingsPanel.classList.add('hidden');
            settingsPanel.classList.remove('flex');

            // Tab Styles
            tabPreview.classList.add(...activeClass);
            tabPreview.classList.remove(...inactiveClass);
            tabSettings.classList.remove(...activeClass);
            tabSettings.classList.add(...inactiveClass);
        } else {
            // Show Settings
            previewPanel.classList.add('hidden');
            previewPanel.classList.remove('flex');
            settingsPanel.classList.remove('hidden');
            settingsPanel.classList.add('flex');

             // Tab Styles
            tabSettings.classList.add(...activeClass);
            tabSettings.classList.remove(...inactiveClass);
            tabPreview.classList.remove(...activeClass);
            tabPreview.classList.add(...inactiveClass);
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        updatePreview();
        // Reset tab to preview on load for mobile (now defined as < 768px)
        if (window.innerWidth < 768) {
            switchPreviewTab('preview');
        }
    });
</script>
@endsection
