<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 30px;
        }
        
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }
        
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #111;
            text-align: right;
        }
        
        .billing-table {
            width: 100%;
            margin-bottom: 30px;
        }
        
        .section-label {
            font-weight: bold;
            color: #4f46e5;
            text-transform: uppercase;
            font-size: 10px;
            margin-bottom: 8px;
            display: block;
        }
        
        .info-table {
            width: 100%;
            border: 1px solid #e5e7eb;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
        }
        
        .info-label {
            background-color: #f9fafb;
            font-weight: bold;
            width: 20%;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th {
            background-color: #4f46e5;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .totals-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .total-row {
            font-size: 14px;
            font-weight: bold;
            background-color: #f9fafb;
        }
        
        .footer {
            margin-top: 50px;
            font-size: 9px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }
        
        .signature-box {
            text-align: center;
            width: 33%;
        }
        
        .signature-space {
            height: 60px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 50%">
                    <div class="company-name">PT. Edo Mandiri Pratama</div>
                    <div style="color: #6b7280">
                        Jakarta, Indonesia<br>
                        Telp: +62 812-3456-7890<br>
                        Email: hello@kelingstudio.com
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="invoice-title">INVOICE</div>
                    <div style="text-align: right; margin-top: 10px;">
                        <strong>Nomor:</strong> {{ $invoice->invoice_number }}<br>
                        <strong>Tanggal:</strong> {{ $invoice->invoice_date->format('d M Y') }}<br>
                        @if($invoice->due_date)
                            <strong>Jatuh Tempo:</strong> {{ $invoice->due_date->format('d M Y') }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="billing-table">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <span class="section-label">Tagihan Kepada:</span>
                <div style="font-size: 13px; font-weight: bold;">{{ $invoice->customer_name }}</div>
                @if($invoice->customer_address)
                    <div>{{ $invoice->customer_address }}</div>
                @endif
                <div>Email: {{ $invoice->customer_email ?? '-' }}</div>
                <div>Telp: {{ $invoice->customer_phone ?? '-' }}</div>
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <span class="section-label">Status Pembayaran:</span>
                <div style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: {{ $invoice->status == 'paid' ? '#059669' : '#d97706' }}">
                    {{ $invoice->status }}
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 40%">Deskripsi Item</th>
                <th class="text-center" style="width: 15%">Kuantitas</th>
                <th class="text-right" style="width: 20%">Harga Satuan</th>
                <th class="text-right" style="width: 25%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
        </tr>
        @if($invoice->tax_percentage > 0)
        <tr>
            <td>PPN ({{ $invoice->tax_percentage }}%)</td>
            <td class="text-right">Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</td>
        </tr>
        @endif
        @if($invoice->discount_percentage > 0)
        <tr>
            <td>Diskon ({{ $invoice->discount_percentage }}%)</td>
            <td class="text-right">- Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
        </tr>
        @endif
        @if($invoice->other_charges > 0)
        <tr>
            <td>Biaya Lainnya</td>
            <td class="text-right">Rp {{ number_format($invoice->other_charges, 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr class="total-row">
            <td>TOTAL</td>
            <td class="text-right">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div style="margin-top: 20px; border: 1px solid #e5e7eb; padding: 10px; background-color: #f9fafb;">
        <span style="font-weight: bold; font-size: 10px; color: #4f46e5; text-transform: uppercase;">Terbilang:</span>
        <div style="font-style: italic; margin-top: 5px;">
            {{ ucwords(\App\Helpers\NumberHelper::terbilang($invoice->total_amount)) }} Rupiah
        </div>
    </div>

    @if($invoice->notes)
    <div style="margin-top: 20px;">
        <span class="section-label">Catatan:</span>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <div class="signature-section">
        <table style="width: 100%">
            <tr>
                <td class="signature-box">
                    <div>Penerima,</div>
                    <div class="signature-space"></div>
                    <div style="border-top: 1px solid #333; display: inline-block; min-width: 120px;">( Pelanggan )</div>
                </td>
                <td class="signature-box"></td>
                <td class="signature-box">
                    <div>Hormat Kami,</div>
                    <div class="signature-space"></div>
                    <div style="border-top: 1px solid #333; display: inline-block; min-width: 120px;">( PT. Edo Mandiri Pratama )</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Terima kasih atas kepercayaan Anda menggunakan layanan kami.
    </div>
</body>
</html>
