// === Tambah Produk ===
// Event listener untuk form submit
document.getElementById('tambah-produk-form').addEventListener('submit', function(event) {
  event.preventDefault(); // Mencegah reload halaman
  // Logika menyimpan data ke backend atau lokal bisa ditambahkan di sini

  // Redirect ke produk.html setelah "penyimpanan"
  window.location.href = 'produk.html';
});

// === Tambah Catatan ===
// Event listener untuk form submit
document.getElementById('tambah-catatan-form').addEventListener('submit', function(event) {
  event.preventDefault(); // Mencegah reload halaman
  // Logika menyimpan data ke backend atau lokal bisa ditambahkan di sini

  // Redirect ke biayaoperasional.html setelah "penyimpanan"
  window.location.href = 'biayaoperasional.html';
});

// === Laporan Keuangan ===
// Simulasi fungsi untuk fetch data dari API (ganti dengan endpoint backend)
async function fetchFinancialData(startDate, endDate) {
  try {
      // Ganti URL di bawah dengan endpoint API 
      const response = await fetch(`/api/financial-report?start=${startDate}&end=${endDate}`);
      if (!response.ok) throw new Error('Failed to fetch financial data');
  
      const data = await response.json();
  
      // Update data di halaman
      document.getElementById('total-pendapatan').textContent = `Rp${formatCurrency(data.totalPendapatan)}`;
      document.getElementById('total-pengeluaran').textContent = `Rp${formatCurrency(data.totalPengeluaran)}`;
      document.getElementById('biaya-operasional').textContent = `Rp${formatCurrency(data.biayaOperasional)}`;
      document.getElementById('total-laba').textContent = `Rp${formatCurrency(data.totalLabaBersih)}`;
  } catch (error) {
      console.error('Error fetching financial data:', error);
      alert('Gagal mengambil data laporan. Coba lagi nanti.');
  }
}

// Format angka ke mata uang
function formatCurrency(value) {
  return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
  }).format(value).replace('Rp', '');
}

// Event handler untuk tombol Generate Laporan
function generateReport() {
  // Ambil tanggal dari input
  const startDate = document.getElementById('from-date').value;
  const endDate = document.getElementById('to-date').value;

  // Validasi input tanggal
  if (!startDate || !endDate) {
      alert('Silakan masukkan periode tanggal lengkap.');
      return;
  }

  // Panggil fungsi fetch data
  fetchFinancialData(startDate, endDate);
}



