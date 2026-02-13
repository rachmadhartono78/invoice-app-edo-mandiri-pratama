<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function preview(Invoice $invoice)
    {
        $invoice->load(['items', 'client']);
        return view('invoices.preview', compact('invoice'));
    }

    public function streamPdf(Invoice $invoice, Request $request)
    {
        $invoice->load(['items', 'client']);
        $template = $request->query('template', 'simple'); // Default to simple

        $view = match ($template) {
                'modern' => 'invoices.pdf-print',
                'business' => 'invoices.pdf-business',
                default => 'invoices.pdf',
            };

        $pdf = Pdf::loadView($view, [
            'invoice' => $invoice
        ])->setPaper('a4', 'portrait');

        $filename = 'Invoice-' . str_replace('/', '-', $invoice->invoice_number) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * @deprecated Use streamPdf instead
     */
    public function print(Invoice $invoice)
    {
        return $this->streamPdf($invoice, new Request(['template' => 'simple']));
    }

    public function printPage(Request $request)
    {
        $query = Invoice::with('items');

        // Reuse search functionality if needed
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();
        return view('invoices.print', compact('invoices'));
    }

    /**
     * @deprecated Use streamPdf instead
     */
    public function printPDF($id)
    {
        $invoice = Invoice::findOrFail($id);
        return $this->streamPdf($invoice, new Request(['template' => 'modern']));
    }

    public function index(Request $request)
    {
        $query = Invoice::with('items');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $newInvoiceNumber = $this->generateInvoiceNumber();
        return view('invoices.create', compact('newInvoiceNumber'));
    }

    private function generateInvoiceNumber()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = "INV/$year/$month";

        // Find last invoice of this month
        $lastInvoice = Invoice::where('invoice_number', 'like', "$prefix/%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInvoice) {
            $parts = explode('/', $lastInvoice->invoice_number);
            $lastNumber = end($parts);
            $nextNumber = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }
        else {
            $nextNumber = '001';
        }

        return "$prefix/$nextNumber";
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'status' => 'required|in:draft,pending,paid,cancelled',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'other_charges' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'payment_terms' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $clientId = $this->findOrCreateClient($request);

            $invoice = Invoice::create([
                'client_id' => $clientId,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_address' => $validated['customer_address'] ?? null,
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'] ?? null,
                'invoice_number' => $validated['invoice_number'],
                'status' => $validated['status'],
                'discount_percentage' => $validated['discount_percentage'] ?? 0,
                'tax_percentage' => $validated['tax_percentage'] ?? 0,
                'other_charges' => $validated['other_charges'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $invoice->items()->create([
                    'item_code' => isset($item['item_code']) ? $item['item_code'] : 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 6)),
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'unit',
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            $invoice->calculateTotals()->save();
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['items', 'client']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required|in:draft,pending,paid,cancelled',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'other_charges' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'payment_terms' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $invoice, $validated) {
            $clientId = $this->findOrCreateClient($request);

            $invoice->update([
                'client_id' => $clientId,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_address' => $validated['customer_address'] ?? null,
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'] ?? null,
                'status' => $validated['status'],
                'discount_percentage' => $validated['discount_percentage'] ?? 0,
                'tax_percentage' => $validated['tax_percentage'] ?? 0,
                'other_charges' => $validated['other_charges'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? null,
            ]);

            // Sync items: Delete all and recreate to ensure accuracy
            $invoice->items()->delete();

            foreach ($validated['items'] as $item) {
                $invoice->items()->create([
                    'item_code' => isset($item['item_code']) ? $item['item_code'] : 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 6)),
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'unit',
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            $invoice->calculateTotals()->save();
        });

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        DB::transaction(function () use ($invoice) {
            $invoice->items()->delete();
            $invoice->delete();
        });
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Find or create a client based on email or phone.
     */
    protected function findOrCreateClient(Request $request)
    {
        $email = $request->customer_email;
        $phone = $request->customer_phone;
        $name = $request->customer_name;
        $address = $request->customer_address;

        $client = null;

        // Try to find by email
        if ($email) {
            $client = \App\Models\Client::where('email', $email)->first();
        }

        // Try to find by phone if not found by email
        if (!$client && $phone) {
            $client = \App\Models\Client::where('phone', $phone)->first();
        }

        $clientData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
        ];

        if ($client) {
            // Update existing client with latest data from invoice
            $client->update($clientData);
        }
        else {
            // Create new client
            $client = \App\Models\Client::create($clientData);
        }

        return $client->id;
    }
}
