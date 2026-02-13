<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('items');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Date range
        if ($request->has('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'invoice_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 15);
        $invoices = $query->paginate($perPage);

        return response()->json($invoices);
    }

    public function store(StoreInvoiceRequest $request)
    {
        $data = $request->validated();

        $clientId = $this->findOrCreateClient($request);
        $data['client_id'] = $clientId;

        $invoice = Invoice::create($data);

        if (isset($data['items'])) {
            foreach ($data['items'] as $index => $itemData) {
                $itemData['sort_order'] = $index + 1;
                $invoice->items()->create($itemData);
            }
        }

        $invoice->calculateTotals()->save();
        $invoice->load(['items', 'client']);

        return response()->json([
            'message' => 'Invoice created successfully',
            'data' => $invoice
        ], 201);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['items', 'client']);
        return response()->json($invoice);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $data = $request->validated();

        $clientId = $this->findOrCreateClient($request);
        $data['client_id'] = $clientId;

        $invoice->update($data);

        if (isset($data['items'])) {
            // Delete old items
            $invoice->items()->delete();

            // Create new items
            foreach ($data['items'] as $index => $itemData) {
                $itemData['sort_order'] = $index + 1;
                $invoice->items()->create($itemData);
            }
        }

        $invoice->calculateTotals()->save();
        $invoice->load(['items', 'client']);

        return response()->json([
            'message' => 'Invoice updated successfully',
            'data' => $invoice
        ]);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ]);
    }

    public function generatePDF(Invoice $invoice)
    {
        $invoice->load('items');

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("Invoice-{$invoice->invoice_number}.pdf");
    }

    public function downloadPDF(Invoice $invoice)
    {
        $invoice->load('items');

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Invoice-{$invoice->invoice_number}.pdf");
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:draft,pending,paid,cancelled'
        ]);

        $invoice->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Invoice status updated successfully',
            'data' => $invoice
        ]);
    }

    /**
     * Find or create a client based on email or phone.
     */
    protected function findOrCreateClient(Request $request)
    {
        // For API, the keys might be different depending on StoreInvoiceRequest
        // But usually they match the model fields: customer_email, customer_phone, etc.
        // We use the same keys as the Web controller for consistency if they are in the request.

        $email = $request->customer_email;
        $phone = $request->customer_phone;
        $name = $request->customer_name;
        $address = $request->customer_address;

        $client = null;

        if ($email) {
            $client = \App\Models\Client::where('email', $email)->first();
        }

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
            $client->update($clientData);
        }
        else {
            $client = \App\Models\Client::create($clientData);
        }

        return $client->id;
    }
}
