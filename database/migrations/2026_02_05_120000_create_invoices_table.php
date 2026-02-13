<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            
            // Customer info
            $table->string('customer_name');
            $table->text('customer_address')->nullable();
            $table->string('customer_phone', 50)->nullable();
            $table->string('customer_email')->nullable();
            
            // Invoice details
            $table->string('payment_terms')->nullable();
            $table->text('notes')->nullable();
            
            // Amounts
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('other_charges', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            
            // Status
            $table->enum('status', ['draft', 'pending', 'paid', 'cancelled'])->default('draft');
            
            // Signatures
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('invoice_date');
            $table->index('status');
            $table->index('customer_name');
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            
            $table->string('item_code', 50);
            $table->string('item_name');
            $table->text('description')->nullable();
            
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 50);
            $table->decimal('unit_price', 15, 2);
            
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            
            $table->decimal('subtotal', 15, 2);
            
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('invoice_id');
            $table->index('item_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
