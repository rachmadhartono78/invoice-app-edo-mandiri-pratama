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
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            padding: 20px;
        }
        
        .header {
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header-flex {
            display: table;
            width: 100%;
        }
        
        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .header-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }
        
        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .customer-info {
            margin-bottom: 15px;
        }
        
        .customer-info p {
            margin-bottom: 3px;
        }
        
        .invoice-details {
            border: 2px solid #333;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .invoice-details table {
            width: 100%;
        }
        
        .invoice-details td {
            padding: 3px 5px;
            vertical-align: top;
        }
        
        .invoice-details td:first-child {
            width: 25%;
            font-weight: bold;
        }
        
        .invoice-details td:nth-child(2) {
            width: 2%;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #333;
            padding: 8px 5px;
            text-align: left;
        }
        
        .items-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .items-table td.number {
            text-align: center;
        }
        
        .items-table td.amount {
            text-align: right;
        }
        
        .terbilang-box {
            border: 2px solid #333;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .terbilang-box strong {
            display: block;
            margin-bottom: 5px;
        }
        
        .summary {
            width: 50%;
            margin-left: auto;
            margin-bottom: 20px;
        }
        
        .summary table {
            width: 100%;
        }
        
        .summary td {
            padding: 5px;
        }
        
        .summary td:first-child {
            text-align: left;
        }
        
        .summary td:last-child {
            text-align: right;
        }
        
        .summary .total-row {
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 8px;
        }
        
        .signatures {
            margin-top: 30px;
        }
        
        .signatures table {
            width: 100%;
        }
        
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-box {
            margin-top: 60px;
            border-bottom: 1px solid #333;
            display: inline-block;
            min-width: 200px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-flex">
                <div class="header-left">
                    <div class="company-name">PT. Edo Mandiri Pratama</div>
                    <p style="font-size: 10px; color: #666; margin: 0;">Jl. Alamat Perusahaan No. 123</p>
                    <p style="font-size: 10px; color: #666; margin: 0;">Telp: (021) 1234-5678 | Email: info@company.com</p>
                </div>
                <div class="header-right">
                    <div class="invoice-title">INVOICE</div>
                    <p style="font-size: 12px; margin: 2px 0;"><strong>No:</strong> {{ $invoice->invoice_number }}</p>
                    <p style="font-size: 12px; margin: 2px 0;"><strong>Date:</strong> {{ $invoice->invoice_date->format('d/m/Y') }}</p>
                    @if($invoice->due_date)
                    <p style="font-size: 12px; margin: 2px 0;"><strong>Due:</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="customer-info">
            <p style="font-weight: bold; margin-bottom: 5px; color: #4f46e5;">BILL TO:</p>
            <p style="font-weight: bold; font-size: 13px; margin: 2px 0;">{{ $invoice->customer_name }}</p>
            @if($invoice->customer_address)
            <p>{{ $invoice->customer_address }}</p>
            @endif
            @if($invoice->customer_phone)
            <p>Telp: {{ $invoice->customer_phone }}</p>
            @endif
            @if($invoice->customer_email)
            <p>Email: {{ $invoice->customer_email }}</p>
            @endif
        </div>

        <div class="invoice-details">
            <table>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                    <td>Nomor</td>
                    <td>:</td>
                    <td>{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td>Jatuh Tempo</td>
                    <td>:</td>
                    <td>{{ $invoice->due_date ? $invoice->due_date->format('d/m/Y') : '-' }}</td>
                    <td>Syarat Pembayaran</td>
                    <td>:</td>
                    <td>{{ $invoice->payment_terms ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Kode</th>
                    <th style="width: 30%">Nama Barang</th>
                    <th style="width: 10%">Jumlah</th>
                    <th style="width: 10%">Satuan</th>
                    <th style="width: 15%">Harga Satuan</th>
                    <th style="width: 15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $index => $item)
                <tr>
                    <td class="number">{{ $index + 1 }}</td>
                    <td>{{ $item->item_code }}</td>
                    <td>
                        {{ $item->item_name }}
                        @if($item->description)
                        <br><small style="color: #666;">{{ $item->description }}</small>
                        @endif
                    </td>
                    <td class="number">{{ number_format($item->quantity, 2, ',', '.') }}</td>
                    <td>{{ $item->unit }}</td>
                    <td class="amount">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="amount">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="terbilang-box">
            <strong>Terbilang:</strong>
            <p style="font-style: italic;">
                {{ ucwords(\App\Helpers\NumberHelper::terbilang($invoice->total_amount)) }} Rupiah
            </p>
        </div>

        <div class="summary">
            <table>
                <tr>
                    <td>Sub Total</td>
                    <td>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($invoice->discount_amount > 0)
                <tr>
                    <td>Diskon ({{ $invoice->discount_percentage }}%)</td>
                    <td>Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($invoice->tax_amount > 0)
                <tr>
                    <td>PPN ({{ $invoice->tax_percentage }}%)</td>
                    <td>Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($invoice->other_charges > 0)
                <tr>
                    <td>Biaya Lain-lain</td>
                    <td>Rp {{ number_format($invoice->other_charges, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td><strong>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        @if($invoice->notes)
        <div style="margin-bottom: 20px;">
            <strong>Catatan:</strong>
            <p>{{ $invoice->notes }}</p>
        </div>
        @endif

        <div class="signatures">
            <table>
                <tr>
                    <td>
                        <p><strong>Disiapkan Oleh,</strong></p>
                        <div class="signature-box"></div>
                        <p>{{ $invoice->prepared_by ?? '________________' }}</p>
                    </td>
                    <td>
                        <p><strong>Disetujui Oleh,</strong></p>
                        <div class="signature-box"></div>
                        <p>{{ $invoice->approved_by ?? '________________' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
