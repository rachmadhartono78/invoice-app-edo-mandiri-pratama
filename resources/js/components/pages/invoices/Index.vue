<template>
  <div class="invoices-page">
    <div class="page-header">
      <h1>Invoice Management</h1>
      <button @click="createInvoice" class="btn btn-primary">
        + Buat Invoice Baru
      </button>
    </div>

    <div class="filters">
      <input 
        v-model="filters.search" 
        type="text" 
        placeholder="Cari invoice..."
        @input="searchInvoices"
        class="search-input"
      />
      
      <select v-model="filters.status" @change="loadInvoices" class="filter-select">
        <option value="">Semua Status</option>
        <option value="draft">Draft</option>
        <option value="pending">Pending</option>
        <option value="paid">Paid</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>

    <div class="table-container">
      <table class="invoices-table">
        <thead>
          <tr>
            <th>Nomor Invoice</th>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="invoice in invoices" :key="invoice.id">
            <td>{{ invoice.invoice_number }}</td>
            <td>{{ formatDate(invoice.invoice_date) }}</td>
            <td>{{ invoice.customer_name }}</td>
            <td>Rp {{ formatNumber(invoice.total_amount) }}</td>
            <td>
              <span :class="['status-badge', invoice.status]">
                {{ invoice.status }}
              </span>
            </td>
            <td>
              <div class="action-buttons">
                <button @click="viewInvoice(invoice.id)" class="btn-icon" title="View">
                  👁️
                </button>
                <button @click="editInvoice(invoice.id)" class="btn-icon" title="Edit">
                  ✏️
                </button>
                <button @click="downloadPDF(invoice.id)" class="btn-icon" title="Download PDF">
                  📄
                </button>
                <button @click="deleteInvoice(invoice.id)" class="btn-icon btn-danger" title="Delete">
                  🗑️
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="invoices.length === 0">
            <td colspan="6" class="text-center">Tidak ada invoice</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="pagination.last_page > 1" class="pagination">
      <button 
        @click="changePage(pagination.current_page - 1)"
        :disabled="pagination.current_page === 1"
        class="btn-page"
      >
        Previous
      </button>
      <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
      <button 
        @click="changePage(pagination.current_page + 1)"
        :disabled="pagination.current_page === pagination.last_page"
        class="btn-page"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const invoices = ref([]);
const pagination = ref({});
const filters = ref({
  search: '',
  status: '',
});

let searchTimeout = null;

const loadInvoices = async (page = 1) => {
  try {
    const response = await axios.get('/api/invoices', {
      params: {
        page,
        search: filters.value.search,
        status: filters.value.status,
      }
    });
    invoices.value = response.data.data;
    pagination.value = response.data;
  } catch (error) {
    console.error('Error loading invoices:', error);
    alert('Gagal memuat invoice');
  }
};

const searchInvoices = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    loadInvoices();
  }, 500);
};

const changePage = (page) => {
  loadInvoices(page);
};

const createInvoice = () => {
  router.push('/invoices/create');
};

const viewInvoice = (id) => {
  router.push(`/invoices/${id}`);
};

const editInvoice = (id) => {
  router.push(`/invoices/${id}/edit`);
};

const downloadPDF = async (id) => {
  try {
    window.open(`/api/invoices/${id}/download`, '_blank');
  } catch (error) {
    console.error('Error downloading PDF:', error);
    alert('Gagal download PDF');
  }
};

const deleteInvoice = async (id) => {
  if (!confirm('Yakin ingin menghapus invoice ini?')) return;
  
  try {
    await axios.delete(`/api/invoices/${id}`);
    loadInvoices();
  } catch (error) {
    console.error('Error deleting invoice:', error);
    alert('Gagal menghapus invoice');
  }
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID');
};

const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num);
};

onMounted(() => {
  loadInvoices();
});
</script>

<style scoped>
.invoices-page {
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

.page-header h1 {
  margin: 0;
  color: #333;
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

.filters {
  display: flex;
  gap: 15px;
  margin-bottom: 20px;
}

.search-input,
.filter-select {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
}

.search-input {
  flex: 1;
}

.table-container {
  overflow-x: auto;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.invoices-table {
  width: 100%;
  border-collapse: collapse;
}

.invoices-table th,
.invoices-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.invoices-table th {
  background: #f5f5f5;
  font-weight: 600;
  color: #666;
}

.invoices-table tr:hover {
  background: #f9f9f9;
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

.action-buttons {
  display: flex;
  gap: 5px;
}

.btn-icon {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
  padding: 5px;
  transition: transform 0.2s;
}

.btn-icon:hover {
  transform: scale(1.2);
}

.btn-danger:hover {
  filter: brightness(1.2);
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  margin-top: 20px;
}

.btn-page {
  padding: 8px 16px;
  border: 1px solid #ddd;
  background: white;
  border-radius: 5px;
  cursor: pointer;
}

.btn-page:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-page:not(:disabled):hover {
  background: #f5f5f5;
}

.text-center {
  text-align: center;
  padding: 40px;
  color: #999;
}
</style>
