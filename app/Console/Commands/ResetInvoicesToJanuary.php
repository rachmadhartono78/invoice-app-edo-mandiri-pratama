<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResetInvoicesToJanuary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:reset-to-january';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move all invoices to January 2026 and renumber them sequentially';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Resetting all invoices to January 2026...");

        $invoices = Invoice::withTrashed()->orderBy('created_at')->get();

        if ($invoices->isEmpty()) {
            $this->info("No invoices found.");
            return;
        }

        if (!$this->confirm("This will change dates and numbers for {$invoices->count()} invoices to Jan 2026. Continue?")) {
            return;
        }

        DB::transaction(function () use ($invoices) {
            // Step 1: Temporary rename to avoid unique constraint violations
            foreach ($invoices as $invoice) {
                $invoice->invoice_number = "TEMP-" . $invoice->id . "-" . uniqid();
                $invoice->save();
            }

            $counter = 1;

            foreach ($invoices as $index => $invoice) {
                // Distribute dates throughout only 5 days of January for variety, or just sequential?
                // User said "testing", let's make it looks somewhat real but simple.
                // Let's spread them from Jan 2 to Jan 31 based on their original order.

                // Simple logic: Just set all to Jan 2026.
                // To keep order, let's map index to day 1-30.
                $day = ($index % 30) + 1;
                $date = Carbon::create(2026, 1, $day);

                // New Number Format: INV/2026/01/001
                $number = "INV/2026/01/" . str_pad($counter, 3, '0', STR_PAD_LEFT);

                $invoice->invoice_date = $date->format('Y-m-d');
                if ($invoice->due_date) {
                    $invoice->due_date = $date->addDays(14)->format('Y-m-d');
                }

                $invoice->invoice_number = $number;
                $invoice->save();

                $this->line("Updated: $number ({$date->toDateString()})");

                $counter++;
            }
        });

        $this->info("All invoices reset to January 2026 successfully!");
    }
}
