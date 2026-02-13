# Panduan Membuat Pipeline (Workflow) GitHub Actions

Ya, betul! Setelah menyiapkan **Runner**, Anda perlu membuat definisi **Pipeline** (disebut *Workflow* di GitHub Actions) agar runner tersebut tahu apa yang harus dikerjakan.

Pipeline ini didefinisikan dalam format **YAML** dan disimpan di dalam folder `.github/workflows/` di repository Anda.

## 1. Struktur Folder

Pastikan struktur folder repository Anda seperti ini:

```text
invoice-app-package/
├── .github/
│   └── workflows/
│       └── main.yml  <-- File pipeline Anda di sini
├── app/
├── ...
```

## 2. Contoh File Pipeline (`main.yml`)

Berikut adalah contoh pipeline sederhana untuk aplikasi Laravel/PHP yang berjalan di **Self-Hosted Runner**:

```yaml
name: Deploy Invoice App

# Kapan pipeline ini berjalan?
on:
  push:
    branches: [ "main" ]
  pull_request:
    branches: [ "main" ]

jobs:
  build-and-test:
    # Bagian ini PENTING: Memberitahu GitHub untuk memakai runner sendiri
    runs-on: self-hosted

    steps:
    # 1. Ambil kode terbaru dari repo
    - name: Checkout code
      uses: actions/checkout@v4

    # 2. Setup PHP (jika belum ada di mesin runner, atau pastikan sudah terinstall)
    # Jika di self-hosted runner sudah install PHP manual, step ini mungkin bisa skip/adjust
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, intl, pdo_sqlite

    # 3. Install dependency
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

    # 4. Buat file .env
    - name: Copy .env
      run: cp .env.example .env

    # 5. Generate Key
    - name: Generate Key
      run: php artisan key:generate

    # 6. Jalankan Test (Opsional)
    - name: Execute tests
      run: php artisan test
```

## Perbedaan Runner GitHub vs Self-Hosted

| Fitur | GitHub-Hosted Runner | Self-Hosted Runner |
| :--- | :--- | :--- |
| **Setup** | Siap pakai (Linux/Win/Mac) | Perlu install & config sendiri |
| **Biaya** | Gratis (terbatas menit/bulan) | Gratis (pakai mesin sendiri) |
| **Lingkungan** | Bersih tiap kali jalan (fresh VM) | Persisten (file lama sisa build sebelumnya masih ada) |
| **YAML** | `runs-on: ubuntu-latest` | `runs-on: self-hosted` |

## Tips untuk Self-Hosted

Karena self-hosted runner tidak "direset" setiap kali selesai, hati-hati dengan file sisa.
*   Gunakan step pembersihan jika perlu.
*   Pastikan path/folder project tidak bentrok antar run (biasanya GitHub runner sudah menangani ini dengan folder `_work` yang unik).
