<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NormalizeInvoiceNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:normalize-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Normalize old invoice numbers to the new format (INV/YYYY/MM/XXX)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting invoice number normalization...");

        // Find invoices with old format (starting with INV- and not containing /)
        $invoices = Invoice::where('invoice_number', 'like', 'INV-%')
            ->where('invoice_number', 'not like', '%/%')
            ->orderBy('invoice_date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($invoices->isEmpty()) {
            $this->info("No invoices found requiring normalization.");
            return;
        }

        $this->info("Found {$invoices->count()} invoices to normalize.");

        if (!$this->confirm("This will update {$invoices->count()} invoice numbers. Do you wish to continue?")) {
            return;
        }

        DB::transaction(function () use ($invoices) {
            foreach ($invoices as $invoice) {
                // Use invoice_date or created_at
                $date = $invoice->invoice_date ?? $invoice->created_at;
                $year = $date->format('Y');
                $month = $date->format('m');
                $prefix = "INV/$year/$month";

                // Generate sequence logic similar to Controller (but we need to handle bulk update within transaction)
                // Since valid numbers might already exist, we need to find the MAX for this month context

                // Note: We can't rely on DB state for sequence inside the loop efficiently if we don't commit.
                // But since we are inside transaction, we can just query.

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

                $newNumber = "$prefix/$nextNumber";

                $this->line("Updating {$invoice->invoice_number} -> $newNumber");

                $invoice->invoice_number = $newNumber;
                $invoice->save();
            }
        });

        $this->info("Normalization completed successfully!");
    }
}
