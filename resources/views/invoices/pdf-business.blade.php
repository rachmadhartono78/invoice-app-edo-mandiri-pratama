<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 9px; color: #333; line-height: 1.3; }
        
        /* Compact Header */
        .header-bg {
            background-color: #1e293b;
            color: white;
            padding: 20px 30px;
        }
        
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        
        .company-name {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .invoice-title {
            font-size: 30px;
            font-weight: 800;
            text-align: right;
            line-height: 1;
        }
        
        .status-badge {
            background: rgba(255,255,255,0.2);
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 5px;
        }
        
        /* Content Area */
        .content { padding: 20px 30px; }
        
        .info-grid { width: 100%; margin-bottom: 20px; }
        .info-grid td { vertical-align: top; width: 33%; padding-right: 15px; }
        
        .section-label {
            font-size: 8px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }
        
        .info-text { font-size: 10px; font-weight: 600; color: #1e293b; }
        .info-sub { font-size: 9px; color: #475569; font-weight: normal; }
        
        /* Compact Items Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .items-table th {
            text-align: left;
            padding: 6px 5px;
            background-color: #f1f5f9;
            border-bottom: 2px solid #cbd5e1;
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8px;
        }
        .items-table td {
            padding: 6px 5px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: top;
        }
        .items-table tr:last-child td { border-bottom: none; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* Totals */
        .totals-container { float: right; width: 40%; }
        .totals-table { width: 100%; border-collapse: collapse; }
        .totals-table td { padding: 3px 0; font-size: 9px; }
        
        .total-row td {
            border-top: 2px solid #1e293b;
            padding-top: 5px;
            margin-top: 5px;
            font-weight: bold;
            font-size: 12px;
            color: #1e293b;
        }
        
        /* Footer / Notes */
        .notes-section { float: left; width: 55%; margin-top: 10px; }
        .payment-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px;
            border-radius: 4px;
            margin-top: 10px;
        }
        
        .signature-section {
            margin-top: 40px;
            clear: both;
            padding-top: 10px;
        }
        
        .signature-box {
            text-align: center;
            width: 25%;
            float: right;
        }
        .signature-line {
            border-bottom: 1px solid #cbd5e1;
            margin-top: 30px;
            margin-bottom: 5px;
        }
        
        .footer-line {
            position: fixed;
            bottom: 0px;
            left: 30px;
            right: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Top Header Block -->
    <div class="header-bg">
        <table class="header-table">
            <tr>
                <td>
                    <div class="company-name">INVOICE APP</div>
                    <div style="font-size: 10px; opacity: 0.8;">PT. Edo Mandiri Pratama</div>
                    <div style="font-size: 9px; opacity: 0.7; margin-top: 2px;">
                        Jakarta, Indonesia | info@company.com
                    </div>
                </td>
                <td style="text-align: right;">
                    <div class="invoice-title">INVOICE</div>
                    <div style="font-size: 11px; opacity: 0.9; margin-top: 2px;">#{{ $invoice->invoice_number }}</div>
                    <div class="status-badge">{{ $invoice->status }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <!-- 3-Column Info Grid -->
        <table class="info-grid">
            <tr>
                <td>
                    <div class="section-label">BILL TO</div>
                    <div class="info-text">{{ $invoice->customer_name }}</div>
                    <div class="info-sub">
                        @if($invoice->customer_address)
                        {{ $invoice->customer_address }}<br>
                        @endif
                        {{ $invoice->customer_email }}
                    </div>
                </td>
                <td>
                    <div class="section-label">DATES</div>
                    <table style="width: 100%">
                        <tr>
                            <td class="info-sub" style="padding-bottom: 2px;">Issued:</td>
                            <td class="info-text" style="padding-bottom: 2px; text-align: right;">{{ $invoice->invoice_date->format('d M Y') }}</td>
                        </tr>
                        @if($invoice->due_date)
                        <tr>
                            <td class="info-sub">Due:</td>
                            <td class="info-text" style="text-align: right;">{{ $invoice->due_date->format('d M Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
                <td style="padding-right: 0;">
                    <div class="section-label">TOTAL AMOUNT</div>
                    <div style="font-size: 18px; font-weight: 800; color: #1e293b; margin-top: 2px;">
                        Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                    </div>
                     <div class="info-sub" style="margin-top: 2px; font-style: italic;">
                        {{ ucwords(\App\Helpers\NumberHelper::terbilang($invoice->total_amount)) }} Rupiah
                    </div>
                </td>
            </tr>
        </table>

        <!-- Compact Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">#</th>
                    <th style="width: 40%">Description</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th style="width: 20%; text-align: right;">Price</th>
                    <th style="width: 20%; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $index => $item)
                <tr>
                    <td class="text-center" style="color: #94a3b8;">{{ $index + 1 }}</td>
                    <td>
                        <strong style="color: #334155;">{{ $item->item_name }}</strong>
                        @if($item->description)
                        <div style="font-size: 8px; color: #64748b; margin-top: 1px;">{{ $item->description }}</div>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: 600;">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Bottom Section: Notes & Totals -->
        <div style="overflow: hidden;">
            <div class="notes-section">
                <div class="section-label">NOTES</div>
                <div class="info-sub" style="margin-bottom: 10px;">
                    {{ $invoice->notes ?? 'Thank you for your business.' }}
                </div>
                
                <div class="section-label">PAYMENT INFO</div>
                <div class="payment-box">
                    <div class="info-text">Bank BCA</div>
                    <div class="info-sub">Acc: 123-456-7890 (PT. Edo Mandiri Pratama)</div>
                </div>
            </div>

            <div class="totals-container">
                <table class="totals-table">
                    <tr>
                        <td class="text-right" style="color: #64748b;">Subtotal</td>
                        <td class="text-right">{{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->tax_amount > 0)
                    <tr>
                        <td class="text-right" style="color: #64748b;">Tax ({{ $invoice->tax_percentage }}%)</td>
                        <td class="text-right">{{ number_format($invoice->tax_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($invoice->discount_amount > 0)
                    <tr>
                        <td class="text-right" style="color: #64748b;">Discount</td>
                        <td class="text-right" style="color: #ef4444;">-{{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td class="text-right">Total</td>
                        <td class="text-right">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="info-sub">Authorized Signature</div>
                <div class="signature-line"></div>
                <div class="info-text">PT. Edo Mandiri Pratama</div>
            </div>
        </div>
        
    </div>
    
    <div class="footer-line">
        {{ $invoice->invoice_number }} | Generated on {{ date('d M Y') }} | Page 1 of 1
    </div>
</body>
</html>
