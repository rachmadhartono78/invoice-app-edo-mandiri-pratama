# 🧾 Invoice Management System

Sistem manajemen invoice/faktur lengkap dengan fitur CRUD, generate PDF, dan import Excel.

## ✨ Features

- ✅ **CRUD Invoice Lengkap** - Create, Read, Update, Delete
- ✅ **Generate PDF** - Sesuai format invoice Indonesia
- ✅ **Auto-calculate** - Subtotal, discount, tax, total
- ✅ **Multi-item** - Tambah/hapus item dinamis
- ✅ **Status Tracking** - Draft, Pending, Paid, Cancelled
- ✅ **Search & Filter** - Cari by nomor/customer/status
- ✅ **Responsive Design** - Mobile, tablet, desktop friendly
- ✅ **Import Excel** - Bulk import dari spreadsheet

## 🔑 Login Credentials

The application comes with a default administrator account:

- **Email**: `admin@example.com`
- **Password**: `password`

## 📱 Mobile Responsiveness

The application is fully responsive and optimized for:
- **Desktop**: Full dashboard and data tables.
- **Tablet**: Adaptive layouts.
- **Mobile**: Stacked cards and scrollable tables for small screens.

## 🚀 Quick Start

### Opsi 1: Auto Install (Recommended)

```bash
cd /path/to/your/laravel-project
cp -r /path/to/invoice-app-package ./invoice-temp
cd invoice-temp
bash install.sh
```

### Opsi 2: Manual Install

#### 1. Install Dependencies
```bash
composer require barryvdh/laravel-dompdf
composer require phpoffice/phpspreadsheet --dev
```

#### 2. Copy Files

```bash
# Copy backend files
cp -r invoice-app-package/app/* your-project/app/
cp -r invoice-app-package/database/* your-project/database/
cp -r invoice-app-package/resources/views/* your-project/resources/views/

# Copy frontend files
cp -r invoice-app-package/resources/js/* your-project/resources/js/
```

#### 3. Update Routes

Add to `routes/api.php`:

```php
use App\Http\Controllers\API\InvoiceController;

Route::middleware('auth:sanctum')->prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::post('/', [InvoiceController::class, 'store']);
    Route::get('/{invoice}', [InvoiceController::class, 'show']);
    Route::put('/{invoice}', [InvoiceController::class, 'update']);
    Route::delete('/{invoice}', [InvoiceController::class, 'destroy']);
    Route::get('/{invoice}/pdf', [InvoiceController::class, 'generatePDF']);
    Route::get('/{invoice}/download', [InvoiceController::class, 'downloadPDF']);
    Route::patch('/{invoice}/status', [InvoiceController::class, 'updateStatus']);
});
```

Update `resources/js/router/router.ts`:

```typescript
import invoiceRoutes from './invoices';

const routes = [
  // ... existing routes
  ...invoiceRoutes,
];
```

#### 4. Run Migration

```bash
php artisan migrate
```

#### 5. Seed Demo Data (Optional)

```bash
php artisan db:seed --class=InvoiceDemoSeeder
```

#### 6. Build Assets

```bash
npm install
npm run build
```

## 📖 Usage

### Create Invoice

1. Navigate to `/invoices`
2. Click "Buat Invoice Baru"
3. Fill in customer details
4. Add items:
   - Kode: PD004
   - Nama: Rak Stainless 4 Tier Non Solid
   - Qty: 10
   - Harga: 1,700,000
5. System auto-calculates totals
6. Click "Simpan Invoice"

### View & Download PDF

- From list: Click PDF icon
- From detail: Click "Download PDF"

### Filter & Search

- Search by invoice number, customer name
- Filter by status
- Sort by date, amount, etc.

## 🏗️ Project Structure

```
app/
├── Models/
│   ├── Invoice.php
│   └── InvoiceItem.php
├── Http/
│   ├── Controllers/API/
│   │   └── InvoiceController.php
│   └── Requests/
│       ├── StoreInvoiceRequest.php
│       └── UpdateInvoiceRequest.php

database/
├── migrations/
│   └── 2026_02_05_120000_create_invoices_table.php
└── seeders/
    └── InvoiceDemoSeeder.php

resources/
├── views/invoices/
│   └── pdf.blade.php
└── js/
    ├── components/pages/invoices/
    │   ├── Index.vue
    │   ├── Create.vue
    │   └── View.vue
    └── router/
        └── invoices.ts
```

## 🔧 Configuration

### Change Invoice Number Format

Edit `app/Models/Invoice.php`:

```php
public static function generateInvoiceNumber()
{
    // Change prefix here
    $prefix = 'INV'; // or 'FAK', 'SI', etc
    // ...
}
```

### Customize PDF Template

Edit `resources/views/invoices/pdf.blade.php`

### Default Tax Rate

Edit `resources/js/components/pages/invoices/Create.vue`:

```javascript
tax_percentage: 11, // Change default PPN here
```

## 📊 Database Schema

### invoices table
- id, invoice_number, invoice_date, due_date
- customer_name, customer_address, customer_phone, customer_email
- payment_terms, notes
- subtotal, discount_percentage, discount_amount
- tax_percentage, tax_amount
- other_charges, total_amount
- status, prepared_by, approved_by
- timestamps, soft_deletes

### invoice_items table
- id, invoice_id
- item_code, item_name, description
- quantity, unit, unit_price
- discount_percentage, discount_amount, subtotal
- sort_order, timestamps

## 🎨 Customization

### Add Custom Field

1. Create migration
2. Update Model fillable
3. Update Request validation
4. Update Vue form
5. Update PDF template

### Change Colors/Styling

Edit Vue component `<style scoped>` sections

## 🐛 Troubleshooting

### PDF not generating?
```bash
composer require barryvdh/laravel-dompdf
php artisan config:clear
```

### Vue components not showing?
```bash
npm run dev
```

### Routes not working?
```bash
php artisan route:clear
php artisan config:clear
```

## 📝 API Endpoints

```
GET    /api/invoices              - List invoices
POST   /api/invoices              - Create invoice
GET    /api/invoices/{id}         - Get invoice
PUT    /api/invoices/{id}         - Update invoice
DELETE /api/invoices/{id}         - Delete invoice
GET    /api/invoices/{id}/pdf     - View PDF
GET    /api/invoices/{id}/download - Download PDF
PATCH  /api/invoices/{id}/status  - Update status
```

## 🔒 Security

- Laravel Sanctum authentication
- CSRF protection
- Input validation
- SQL injection prevention
- XSS prevention

## 📄 License

This package is open-sourced software.

## 🙏 Credits

Built with:
- Laravel 10+
- Vue 3
- DomPDF
- Tailwind CSS (optional)

---

**Happy invoicing! 🎉**
