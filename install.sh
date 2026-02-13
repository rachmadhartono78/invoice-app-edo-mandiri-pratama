#!/bin/bash

echo "🚀 Invoice Management System - Auto Installer"
echo "=============================================="
echo ""

# Check if we're in the right directory
if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json not found!"
    echo "Please run this script from your Laravel project root directory"
    exit 1
fi

echo "📦 Step 1: Installing PHP dependencies..."
composer require barryvdh/laravel-dompdf
composer require phpoffice/phpspreadsheet --dev

echo ""
echo "📁 Step 2: Copying backend files..."
cp -r app/* ../app/ 2>/dev/null || echo "Copying app files..."
cp -r database/* ../database/ 2>/dev/null || echo "Copying database files..."
cp -r resources/views/* ../resources/views/ 2>/dev/null || echo "Copying views..."

echo ""
echo "📁 Step 3: Copying frontend files..."
cp -r resources/js/* ../resources/js/ 2>/dev/null || echo "Copying JS files..."

echo ""
echo "🔧 Step 4: Running migrations..."
php artisan migrate

echo ""
read -p "Do you want to seed demo data? (y/n) " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed --class=InvoiceDemoSeeder
fi

echo ""
echo "📦 Step 5: Installing npm dependencies and building..."
npm install
npm run build

echo ""
echo "✅ Installation complete!"
echo ""
echo "📌 Next steps:"
echo "1. Add routes to routes/api.php (see README.md)"
echo "2. Update resources/js/router/router.ts to include invoice routes"
echo "3. Run: php artisan serve"
echo "4. Visit: http://localhost:8000/invoices"
echo ""
echo "📖 Read README.md for complete documentation"
echo ""
