<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Invoice;
use App\Models\Client;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Iterate through invoices without a client_id
        Invoice::whereNull('client_id')->chunk(100, function ($invoices) {
            foreach ($invoices as $invoice) {
                $email = $invoice->customer_email;
                $phone = $invoice->customer_phone;

                $client = null;

                // Try to find existing client
                if ($email) {
                    $client = Client::where('email', $email)->first();
                }

                if (!$client && $phone) {
                    $client = Client::where('phone', $phone)->first();
                }

                // If no client found, create one from invoice data
                if (!$client) {
                    $client = Client::create([
                        'name' => $invoice->customer_name,
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $invoice->customer_address,
                    ]);
                }

                // Link the invoice
                $invoice->update(['client_id' => $client->id]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    // No easy way to reverse this without losing information on which were null before.
    // But since we are just filling nulls, we can leave it as is or reset if needed.
    }
};
