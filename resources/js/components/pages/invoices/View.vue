<template>
  <div class="invoice-view-page" v-if="invoice">
    <div class="page-header">
      <h1>Invoice {{ invoice.invoice_number }}</h1>
      <div class="header-actions">
        <button @click="downloadPDF" class="btn btn-primary">📄 Download PDF</button>
        <button @click="editInvoice" class="btn btn-secondary">✏️ Edit</button>
        <button @click="goBack" class="btn btn-secondary">Kembali</button>
      </div>
    </div>

    <div class="invoice-preview">
      <div class="invoice-header-section">
        <div class="company-header">
          <h2>Indonesia</h2>
          <h1>Faktur Penjualan</h1>
        </div>

        <div class="customer-info">
          <p><strong>Kepada:</strong></p>
          <p><strong>{{ invoice.customer_name }}</strong></p>
          <p v-if="invoice.customer_address">{{ invoice.customer_address }}</p>
          <p v-if="invoice.customer_phone">Telp: {{ invoice.customer_phone }}</p>
          <p v-if="invoice.customer_email">Email: {{ invoice.customer_email }}</p>
        </div>

        <div class="invoice-details-box">
          <table>
            <tr>
              <td><strong>Tanggal</strong></td>
              <td>:</td>
              <td>{{ formatDate(invoice.invoice_date) }}</td>
              <td><strong>Nomor</strong></td>
              <td>:</td>
              <td>{{ invoice.invoice_number }}</td>
            </tr>
            <tr>
              <td><strong>Jatuh Tempo</strong></td>
              <td>:</td>
              <td>{{ invoice.due_date ? formatDate(invoice.due_date) : '-' }}</td>
              <td><strong>Syarat Pembayaran</strong></td>
              <td>:</td>
              <td>{{ invoice.payment_terms || '-' }}</td>
            </tr>
            <tr>
              <td><strong>Status</strong></td>
              <td>:</td>
              <td colspan="4">
                <span :class="['status-badge', invoice.status]">
                  {{ invoice.status }}
                </span>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="items-section">
        <table class="items-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama Barang</th>
              <th>Jumlah</th>
              <th>Satuan</th>
              <th>Harga Satuan</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in invoice.items" :key="item.id">
              <td class="text-center">{{ index + 1 }}</td>
              <td>{{ item.item_code }}</td>
              <td>
                {{ item.item_name }}
                <div v-if="item.description" class="item-description">{{ item.description }}</div>
              </td>
              <td class="text-right">{{ formatNumber(item.quantity) }}</td>
              <td>{{ item.unit }}</td>
              <td class="text-right">Rp {{ formatNumber(item.unit_price) }}</td>
              <td class="text-right">Rp {{ formatNumber(item.subtotal) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="totals-section">
        <div class="summary-box">
          <div class="summary-row">
            <span>Sub Total</span>
            <span>Rp {{ formatNumber(invoice.subtotal) }}</span>
          </div>
          <div class="summary-row" v-if="invoice.discount_amount > 0">
            <span>Diskon ({{ invoice.discount_percentage }}%)</span>
            <span>- Rp {{ formatNumber(invoice.discount_amount) }}</span>
          </div>
          <div class="summary-row" v-if="invoice.tax_amount > 0">
            <span>PPN ({{ invoice.tax_percentage }}%)</span>
            <span>Rp {{ formatNumber(invoice.tax_amount) }}</span>
          </div>
          <div class="summary-row" v-if="invoice.other_charges > 0">
            <span>Biaya Lain-lain</span>
            <span>Rp {{ formatNumber(invoice.other_charges) }}</span>
          </div>
          <div class="summary-row total">
            <strong>TOTAL</strong>
            <strong>Rp {{ formatNumber(invoice.total_amount) }}</strong>
          </div>
        </div>

        <div class="terbilang-box">
          <strong>Terbilang:</strong>
          <p>{{ terbilang(invoice.total_amount) }} Rupiah</p>
        </div>
      </div>

      <div v-if="invoice.notes" class="notes-section">
        <strong>Catatan:</strong>
        <p>{{ invoice.notes }}</p>
      </div>

      <div class="signatures-section">
        <div class="signature-box">
          <strong>Disiapkan Oleh,</strong>
          <div class="signature-line"></div>
          <p>{{ invoice.prepared_by || '________________' }}</p>
        </div>
        <div class="signature-box">
          <strong>Disetujui Oleh,</strong>
          <div class="signature-line"></div>
          <p>{{ invoice.approved_by || '________________' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const route = useRoute();
const invoice = ref(null);

const loadInvoice = async () => {
  try {
    const response = await axios.get(`/api/invoices/${route.params.id}`);
    invoice.value = response.data;
  } catch (error) {
    console.error('Error loading invoice:', error);
    alert('Gagal memuat invoice');
  }
};

const downloadPDF = () => {
  window.open(`/api/invoices/${route.params.id}/download`, '_blank');
};

const editInvoice = () => {
  router.push(`/invoices/${route.params.id}/edit`);
};

const goBack = () => {
  router.push('/invoices');
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID');
};

const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num);
};

const terbilang = (angka) => {
  const huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
  
  angka = Math.abs(angka);
  
  if (angka < 12) return huruf[angka];
  if (angka < 20) return terbilang(angka - 10) + " Belas";
  if (angka < 100) return terbilang(Math.floor(angka / 10)) + " Puluh " + terbilang(angka % 10);
  if (angka < 200) return "Seratus " + terbilang(angka - 100);
  if (angka < 1000) return terbilang(Math.floor(angka / 100)) + " Ratus " + terbilang(angka % 100);
  if (angka < 2000) return "Seribu " + terbilang(angka - 1000);
  if (angka < 1000000) return terbilang(Math.floor(angka / 1000)) + " Ribu " + terbilang(angka % 1000);
  if (angka < 1000000000) return terbilang(Math.floor(angka / 1000000)) + " Juta " + terbilang(angka % 1000000);
  
  return "Angka terlalu besar";
};

onMounted(() => {
  loadInvoice();
});
</script>

<style scoped>
.invoice-view-page {
  padding: 20px;
  max-width: 1000px;
  margin: 0 auto;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.header-actions {
  display: flex;
  gap: 10px;
}

.invoice-preview {
  background: white;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.company-header {
  text-align: center;
  margin-bottom: 30px;
}

.company-header h2 {
  font-size: 16px;
  font-weight: normal;
  margin-bottom: 5px;
}

.company-header h1 {
  font-size: 24px;
  margin: 0;
}

.customer-info {
  margin-bottom: 20px;
}

.customer-info p {
  margin: 5px 0;
}

.invoice-details-box {
  border: 2px solid #333;
  padding: 15px;
  margin-bottom: 30px;
}

.invoice-details-box table {
  width: 100%;
}

.invoice-details-box td {
  padding: 5px;
}

.items-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 30px;
}

.items-table th,
.items-table td {
  border: 1px solid #333;
  padding: 10px;
  text-align: left;
}

.items-table th {
  background: #f0f0f0;
  text-align: center;
}

.item-description {
  font-size: 12px;
  color: #666;
  margin-top: 5px;
}

.text-center {
  text-align: center;
}

.text-right {
  text-align: right;
}

.summary-box {
  width: 50%;
  margin-left: auto;
  margin-bottom: 20px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
}

.summary-row.total {
  border-top: 2px solid #333;
  margin-top: 10px;
  padding-top: 15px;
  font-size: 18px;
}

.terbilang-box {
  border: 2px solid #333;
  padding: 15px;
  margin-bottom: 30px;
}

.terbilang-box p {
  margin-top: 10px;
  font-style: italic;
}

.notes-section {
  margin-bottom: 30px;
}

.signatures-section {
  display: flex;
  justify-content: space-between;
  margin-top: 50px;
}

.signature-box {
  text-align: center;
  width: 45%;
}

.signature-line {
  height: 60px;
  border-bottom: 1px solid #333;
  margin: 20px auto;
  width: 200px;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
}

.status-badge.draft {
  background: #e0e0e0;
  color: #666;
}

.status-badge.pending {
  background: #fff3cd;
  color: #856404;
}

.status-badge.paid {
  background: #d4edda;
  color: #155724;
}

.status-badge.cancelled {
  background: #f8d7da;
  color: #721c24;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.3s;
}

.btn-primary {
  background: #4CAF50;
  color: white;
}

.btn-primary:hover {
  background: #45a049;
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background: #5a6268;
}
</style>
