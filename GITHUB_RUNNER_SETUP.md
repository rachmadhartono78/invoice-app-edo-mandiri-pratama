# Panduan Membuat Self-Hosted Runner di GitHub

Dokumen ini menjelaskan cara mengatur **Self-Hosted Runner** di GitHub untuk menjalankan workflow CI/CD pada mesin Anda sendiri (server atau lokal).

## Prasyarat

1.  Akses admin ke repository GitHub.
2.  Mesin (Linux, macOS, atau Windows) yang akan digunakan sebagai runner.
3.  Koneksi internet yang stabil.

## Langkah-langkah Setup

### 1. Buka Pengaturan Repository

1.  Buka halaman repository Anda di GitHub.
2.  Klik tab **Settings** (Pengaturan).
3.  Di menu sebelah kiri, pilih **Actions** -> **Runners**.
4.  Klik tombol hijau **New self-hosted runner**.

### 2. Pilih Sistem Operasi

Pilih gambar sistem operasi yang sesuai dengan mesin Anda:
-   **macOS**
-   **Linux**
-   **Windows**

### 3. Download dan Konfigurasi Runner

GitHub akan memberikan serangkaian perintah spesifik untuk sistem operasi Anda. Jalankan perintah tersebut di terminal/PowerShell mesin runner Anda.

#### Contoh untuk Windows (PowerShell):

1.  **Buat folder:**
    ```powershell
    mkdir actions-runner; cd actions-runner
    ```

2.  **Download paket runner:**
    *(Salin perintah curl/Invoke-WebRequest dari halaman GitHub Anda karena mengandung versi terbaru)*
    ```powershell
    Invoke-WebRequest -Uri https://github.com/actions/runner/releases/download/v2.x.x/actions-runner-win-x64-2.x.x.zip -OutFile actions-runner-win-x64-2.x.x.zip
    ```

3.  **Ekstrak installer:**
    ```powershell
    Add-Type -AssemblyName System.IO.Compression.FileSystem ; [System.IO.Compression.ZipFile]::ExtractToDirectory("$PWD/actions-runner-win-x64-2.x.x.zip", "$PWD")
    ```

4.  **Konfigurasi runner:**
    ```powershell
    ./config.cmd --url https://github.com/USERNAME/REPO_NAME --token XXXXXXXXXXXXXXXXXXXXXXXXX
    ```
    *   Ikuti petunjuk di layar (tekan Enter untuk default).
    *   Isi nama runner, label, dan work folder jika diminta.

### 4. Menjalankan Runner

Setelah konfigurasi selesai, Anda bisa menjalankan runner secara interaktif atau sebagai service.

#### Jalankan secara interaktif (untuk testing):
```powershell
./run.cmd
```
*Runner akan mulai mendengarkan jobs (Listening for Jobs).*

#### Jalankan sebagai Service (agar jalan di background/startup):
*(Jalankan PowerShell sebagai Administrator)*

```powershell
./svc.sh install  # (Linux/macOS) atau cmd khusus windows biasanya ada instruksi lanjut
# Untuk Windows biasanya:
./svc.cmd install
./svc.cmd start
```

## Menggunakan Runner di Workflow

Untuk menggunakan self-hosted runner ini di file workflow (`.github/workflows/nama-file.yml`), ubah bagian `runs-on`:

```yaml
jobs:
  build:
    runs-on: self-hosted
    # Atau jika menggunakan label khusus:
    # runs-on: [self-hosted, windows, x64]
    
    steps:
      - uses: actions/checkout@v3
      - name: Run a script
        run: echo "Hello from self-hosted runner!"
```

## Catatan Penting

*   **Keamanan:** Jangan gunakan self-hosted runner pada repository publik kecuali Anda yakin aman, karena pull request dari fork bisa menjalankan kode berbahaya di mesin Anda.
*   **Maintenance:** Anda bertanggung jawab untuk mengupdate tools (Node.js, PHP, Docker, dll) di mesin runner tersebut.
