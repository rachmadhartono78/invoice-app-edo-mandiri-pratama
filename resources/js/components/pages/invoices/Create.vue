<template>
  <div class="invoice-form-page">
    <div class="page-header">
      <h1>{{ isEdit ? 'Edit Invoice' : 'Buat Invoice Baru' }}</h1>
      <button @click="goBack" class="btn btn-secondary">Kembali</button>
    </div>

    <form @submit.prevent="saveInvoice" class="invoice-form">
      <div class="form-section">
        <h3>Informasi Customer</h3>
        <div class="form-grid">
          <div class="form-group">
            <label>Nama Customer *</label>
            <input v-model="form.customer_name" type="text" required />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input v-model="form.customer_email" type="email" />
          </div>
          <div class="form-group full-width">
            <label>Alamat</label>
            <textarea v-model="form.customer_address" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label>Telepon</label>
            <input v-model="form.customer_phone" type="text" />
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3>Detail Invoice</h3>
        <div class="form-grid">
          <div class="form-group">
            <label>Tanggal Invoice *</label>
            <input v-model="form.invoice_date" type="date" required />
          </div>
          <div class="form-group">
            <label>Jatuh Tempo</label>
            <input v-model="form.due_date" type="date" />
          </div>
          <div class="form-group">
            <label>Syarat Pembayaran</label>
            <input v-model="form.payment_terms" type="text" placeholder="Contoh: 14 hari" />
          </div>
          <div class="form-group">
            <label>Status</label>
            <select v-model="form.status">
              <option value="draft">Draft</option>
              <option value="pending">Pending</option>
              <option value="paid">Paid</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>
      </div>

      <div class="form-section">
        <div class="section-header">
          <h3>Item Barang</h3>
          <button type="button" @click="addItem" class="btn btn-sm btn-primary">+ Tambah Item</button>
        </div>

        <div class="items-list">
          <div v-for="(item, index) in form.items" :key="index" class="item-row">
            <div class="item-grid">
              <div class="form-group">
                <label>Kode *</label>
                <input v-model="item.item_code" type="text" required />
              </div>
              <div class="form-group">
                <label>Nama Barang *</label>
                <input v-model="item.item_name" type="text" required />
              </div>
              <div class="form-group">
                <label>Qty *</label>
                <input v-model.number="item.quantity" type="number" step="0.01" required @input="calculateItem(index)" />
              </div>
              <div class="form-group">
                <label>Satuan *</label>
                <input v-model="item.unit" type="text" required />
              </div>
              <div class="form-group">
                <label>Harga *</label>
                <input v-model.number="item.unit_price" type="number" step="0.01" required @input="calculateItem(index)" />
              </div>
              <div class="form-group">
                <label>Diskon %</label>
                <input v-model.number="item.discount_percentage" type="number" step="0.01" min="0" max="100" @input="calculateItem(index)" />
              </div>
              <div class="form-group">
                <label>Subtotal</label>
                <input :value="formatNumber(item.subtotal || 0)" type="text" disabled />
              </div>
              <div class="form-group">
                <button type="button" @click="removeItem(index)" class="btn btn-danger btn-sm">🗑️</button>
              </div>
            </div>
            <div class="form-group full-width">
              <label>Deskripsi</label>
              <input v-model="item.description" type="text" />
            </div>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3>Perhitungan</h3>
        <div class="calculation-grid">
          <div class="form-group">
            <label>Diskon Total %</label>
            <input v-model.number="form.discount_percentage" type="number" step="0.01" min="0" max="100" @input="calculateTotals" />
          </div>
          <div class="form-group">
            <label>PPN %</label>
            <input v-model.number="form.tax_percentage" type="number" step="0.01" min="0" max="100" @input="calculateTotals" />
          </div>
          <div class="form-group">
            <label>Biaya Lain-lain</label>
            <input v-model.number="form.other_charges" type="number" step="0.01" min="0" @input="calculateTotals" />
          </div>
        </div>

        <div class="totals-summary">
          <div class="total-row">
            <span>Subtotal:</span>
            <strong>Rp {{ formatNumber(totals.subtotal) }}</strong>
          </div>
          <div class="total-row" v-if="totals.discount > 0">
            <span>Diskon ({{ form.discount_percentage }}%):</span>
            <strong>- Rp {{ formatNumber(totals.discount) }}</strong>
          </div>
          <div class="total-row" v-if="totals.tax > 0">
            <span>PPN ({{ form.tax_percentage }}%):</span>
            <strong>Rp {{ formatNumber(totals.tax) }}</strong>
          </div>
          <div class="total-row" v-if="form.other_charges > 0">
            <span>Biaya Lain-lain:</span>
            <strong>Rp {{ formatNumber(form.other_charges) }}</strong>
          </div>
          <div class="total-row grand-total">
            <span>TOTAL:</span>
            <strong>Rp {{ formatNumber(totals.total) }}</strong>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3>Tanda Tangan</h3>
        <div class="form-grid">
          <div class="form-group">
            <label>Disiapkan Oleh</label>
            <input v-model="form.prepared_by" type="text" />
          </div>
          <div class="form-group">
            <label>Disetujui Oleh</label>
            <input v-model="form.approved_by" type="text" />
          </div>
        </div>
      </div>

      <div class="form-section">
        <div class="form-group full-width">
          <label>Catatan</label>
          <textarea v-model="form.notes" rows="3"></textarea>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" @click="goBack" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Invoice</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const route = useRoute();
const isEdit = computed(() => !!route.params.id);

const form = reactive({
  customer_name: '',
  customer_email: '',
  customer_address: '',
  customer_phone: '',
  invoice_date: new Date().toISOString().split('T')[0],
  due_date: '',
  payment_terms: '',
  status: 'draft',
  discount_percentage: 0,
  tax_percentage: 11,
  other_charges: 0,
  prepared_by: '',
  approved_by: '',
  notes: '',
  items: [
    {
      item_code: '',
      item_name: '',
      description: '',
      quantity: 1,
      unit: 'Unit',
      unit_price: 0,
      discount_percentage: 0,
      subtotal: 0,
    }
  ],
});

const totals = computed(() => {
  const subtotal = form.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
  const discount = subtotal * (form.discount_percentage / 100);
  const afterDiscount = subtotal - discount;
  const tax = afterDiscount * (form.tax_percentage / 100);
  const total = afterDiscount + tax + (form.other_charges || 0);

  return { subtotal, discount, tax, total };
});

const addItem = () => {
  form.items.push({
    item_code: '',
    item_name: '',
    description: '',
    quantity: 1,
    unit: 'Unit',
    unit_price: 0,
    discount_percentage: 0,
    subtotal: 0,
  });
};

const removeItem = (index) => {
  if (form.items.length > 1) {
    form.items.splice(index, 1);
    calculateTotals();
  }
};

const calculateItem = (index) => {
  const item = form.items[index];
  const total = item.quantity * item.unit_price;
  const discount = total * (item.discount_percentage / 100);
  item.subtotal = total - discount;
  calculateTotals();
};

const calculateTotals = () => {
  // Trigger reactivity
  form.items = [...form.items];
};

const loadInvoice = async () => {
  try {
    const response = await axios.get(`/api/invoices/${route.params.id}`);
    Object.assign(form, response.data);
  } catch (error) {
    console.error('Error loading invoice:', error);
    alert('Gagal memuat invoice');
  }
};

const saveInvoice = async () => {
  try {
    const data = {
      ...form,
      subtotal: totals.value.subtotal,
      discount_amount: totals.value.discount,
      tax_amount: totals.value.tax,
      total_amount: totals.value.total,
    };

    if (isEdit.value) {
      await axios.put(`/api/invoices/${route.params.id}`, data);
    } else {
      await axios.post('/api/invoices', data);
    }

    router.push('/invoices');
  } catch (error) {
    console.error('Error saving invoice:', error);
    alert('Gagal menyimpan invoice');
  }
};

const goBack = () => {
  router.push('/invoices');
};

const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num || 0);
};

onMounted(() => {
  if (isEdit.value) {
    loadInvoice();
  }
});
</script>

<style scoped>
.invoice-form-page {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.invoice-form {
  background: white;
  border-radius: 8px;
  padding: 30px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-section {
  margin-bottom: 30px;
  padding-bottom: 30px;
  border-bottom: 1px solid #eee;
}

.form-section:last-of-type {
  border-bottom: none;
}

.form-section h3 {
  margin-bottom: 20px;
  color: #333;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.form-group input,
.form-group select,
.form-group textarea {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
}

.form-group input:disabled {
  background: #f5f5f5;
  cursor: not-allowed;
}

.items-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.item-row {
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background: #f9f9f9;
}

.item-grid {
  display: grid;
  grid-template-columns: 100px 1fr 80px 80px 120px 80px 120px 50px;
  gap: 10px;
  align-items: end;
}

.calculation-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 20px;
}

.totals-summary {
  background: #f5f5f5;
  padding: 20px;
  border-radius: 5px;
}

.total-row {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  font-size: 14px;
}

.total-row.grand-total {
  border-top: 2px solid #333;
  margin-top: 10px;
  padding-top: 15px;
  font-size: 18px;
  font-weight: bold;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  padding-top: 20px;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.3s;
}

.btn-sm {
  padding: 5px 10px;
  font-size: 12px;
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

.btn-danger {
  background: #dc3545;
  color: white;
}

.btn-danger:hover {
  background: #c82333;
}

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
  
  .item-grid {
    grid-template-columns: 1fr;
  }
  
  .calculation-grid {
    grid-template-columns: 1fr;
  }
}
</style>
