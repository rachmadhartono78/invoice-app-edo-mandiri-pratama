<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceDemoSeeder extends Seeder
{
    public function run()
    {
        $invoices = [
            [
                'invoice_date' => '2026-02-01',
                'due_date' => '2026-02-15',
                'customer_name' => 'PT. Maju Jaya',
                'customer_address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'customer_phone' => '021-1234567',
                'customer_email' => 'info@majujaya.com',
                'payment_terms' => '14 hari',
                'notes' => 'Terima kasih atas kepercayaan Anda',
                'discount_percentage' => 5,
                'tax_percentage' => 11,
                'other_charges' => 50000,
                'status' => 'paid',
                'prepared_by' => 'John Doe',
                'approved_by' => 'Jane Smith',
                'items' => [
                    [
                        'item_code' => 'PD004',
                        'item_name' => 'Rak Stainless 4 Tier Non Solid',
                        'description' => 'Rak penyimpanan stainless steel 4 tingkat',
                        'quantity' => 10,
                        'unit' => 'Unit',
                        'unit_price' => 1700000,
                        'discount_percentage' => 0,
                    ],
                    [
                        'item_code' => 'PD005',
                        'item_name' => 'Meja Kerja Stainless',
                        'description' => 'Meja kerja stainless steel 150x60cm',
                        'quantity' => 5,
                        'unit' => 'Unit',
                        'unit_price' => 2500000,
                        'discount_percentage' => 0,
                    ],
                ],
            ],
            [
                'invoice_date' => '2026-02-03',
                'due_date' => '2026-02-17',
                'customer_name' => 'CV. Berkah Sentosa',
                'customer_address' => 'Jl. Gatot Subroto No. 45, Bandung',
                'customer_phone' => '022-7654321',
                'customer_email' => 'berkah@sentosa.com',
                'payment_terms' => '14 hari',
                'discount_percentage' => 10,
                'tax_percentage' => 11,
                'status' => 'pending',
                'prepared_by' => 'Alice Johnson',
                'approved_by' => 'Bob Wilson',
                'items' => [
                    [
                        'item_code' => 'PD001',
                        'item_name' => 'Lemari Pendingin 2 Pintu',
                        'description' => 'Lemari pendingin kapasitas 500L',
                        'quantity' => 3,
                        'unit' => 'Unit',
                        'unit_price' => 8500000,
                        'discount_percentage' => 0,
                    ],
                ],
            ],
            [
                'invoice_date' => '2026-02-04',
                'customer_name' => 'Toko ABC',
                'customer_address' => 'Jl. Ahmad Yani No. 78, Surabaya',
                'customer_phone' => '031-9876543',
                'payment_terms' => '30 hari',
                'tax_percentage' => 11,
                'status' => 'draft',
                'prepared_by' => 'Charlie Brown',
                'items' => [
                    [
                        'item_code' => 'PD002',
                        'item_name' => 'Kompor Gas Industrial',
                        'description' => 'Kompor gas 4 tungku heavy duty',
                        'quantity' => 2,
                        'unit' => 'Unit',
                        'unit_price' => 4200000,
                        'discount_percentage' => 5,
                    ],
                    [
                        'item_code' => 'PD003',
                        'item_name' => 'Deep Fryer Listrik',
                        'description' => 'Deep fryer kapasitas 12L',
                        'quantity' => 4,
                        'unit' => 'Unit',
                        'unit_price' => 3500000,
                        'discount_percentage' => 0,
                    ],
                ],
            ],
            [
                'invoice_date' => '2026-01-28',
                'customer_name' => 'Restoran XYZ',
                'customer_address' => 'Jl. Thamrin No. 99, Jakarta',
                'payment_terms' => '7 hari',
                'tax_percentage' => 11,
                'status' => 'cancelled',
                'items' => [
                    [
                        'item_code' => 'PD006',
                        'item_name' => 'Oven Listrik',
                        'quantity' => 1,
                        'unit' => 'Unit',
                        'unit_price' => 12000000,
                    ],
                ],
            ],
        ];

        foreach ($invoices as $invoiceData) {
            $items = $invoiceData['items'];
            unset($invoiceData['items']);

            $invoice = Invoice::create($invoiceData);

            foreach ($items as $index => $itemData) {
                $itemData['sort_order'] = $index + 1;
                $invoice->items()->create($itemData);
            }

            $invoice->calculateTotals()->save();
        }

        $this->command->info('✅ Demo invoices created successfully!');
        $this->command->info('   Created ' . count($invoices) . ' invoices with items');
    }
}
