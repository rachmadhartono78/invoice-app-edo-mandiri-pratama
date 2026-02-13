# ⚡ Quick Start Guide - 5 Minutes

## 1️⃣ Extract Package (1 min)

```bash
unzip invoice-management-system.zip
cd invoice-management-system
```

## 2️⃣ Run Auto Installer (2 min)

```bash
# Navigate to your Laravel project
cd /path/to/your/laravel-project

# Copy package into project
cp -r /path/to/invoice-management-system ./invoice-temp
cd invoice-temp

# Run installer
bash install.sh
```

The installer will automatically:
- ✅ Install dependencies
- ✅ Copy all files
- ✅ Run migrations
- ✅ Build assets
- ✅ (Optional) Seed demo data

## 3️⃣ Update Routes (1 min)

### Add to `routes/api.php`:

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

### Update `resources/js/router/router.ts`:

```typescript
import invoiceRoutes from './invoices';

const routes = [
  // ... existing routes
  ...invoiceRoutes,
];
```

## 4️⃣ Start Server (30 sec)

```bash
php artisan serve
```

## 5️⃣ Access Application (30 sec)

Open browser: `http://localhost:8000/invoices`

## 🎉 Done!

You now have a fully functional invoice management system!

### Quick Test:

1. Click "Buat Invoice Baru"
2. Fill in customer: "PT. Test"
3. Add item:
   - Kode: TEST001
   - Nama: Test Product
   - Qty: 5
   - Harga: 100000
4. Click "Simpan Invoice"
5. Click PDF icon to download

## 📚 Need More Help?

- Full documentation: `README.md`
- API reference: Check routes-api-example.php
- Troubleshooting: See README.md

---

**Total time: ~5 minutes** ⚡
