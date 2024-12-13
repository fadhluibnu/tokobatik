<?php
$active = 'penjualan';
include '../components/header.php';

include '../controller/produk.php';
$produks = getProduk();

include '../controller/LaporanKeuangan.php';
$laporanKeuangan = getLaporanKeuangan();

include '../controller/penjualan.php';
if (isset($_POST['simpan'])) {
    echo "<script>console.log('POST', " . json_encode($_POST) . ")</script>";
    $data = [
        'id_laporan_keuangan' => $_POST['id_laporan_keuangan'],
        'id_diskon' => $_POST['id_diskon'],
        'pajak' => $_POST['pajak'],
        'total_bayar' => $_POST['total_bayar'],
        'metode_pembayaran' => $_POST['metode_pembayaran'],
        'tanggal_jual' => $_POST['tanggal_jual'],
        'catatan_penjualan' => $_POST['catatan_penjualan'],
        'id_produk' => $_POST['id_produk'],
        'jumlah_produk' => $_POST['jumlah_produk'],
        'harga_per_item' => $_POST['harga_per_item']
    ];
    $result = tambahPenjualan($data);
    if ($result > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            window.location.href = '/penjualan';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            window.location.href = '/penjualan/tambah.php';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">
    <?php

    $titleMain = 'Tambah Penjualan';
    include '../components/header-main.php';

    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form id="tambah-penjualan-form" action="/penjualan/tambah.php" method="post">
            <div class="grid grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="order-1">
                    <label for="id_laporan_keuangan" class="block text-sm font-medium text-gray-700">Laporan Keuangan</label>
                    <select id="id_laporan_keuangan" name="id_laporan_keuangan" class="form-input w-full" required>
                        <option value="">Pilih Laporan Keuangan</option>
                        <?php foreach ($laporanKeuangan as $laporan): ?>
                            <option value="<?php echo $laporan['id_laporan']; ?>">
                                <?php echo date('j F Y', strtotime($laporan['periode_mulai'])) . ' - ' . date('j F Y', strtotime($laporan['periode_selesai'])); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="order-5">
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <select id="nama_produk" name="id_produk" class="form-input w-full" required>
                        <option value="">Pilih Produk</option>
                        <?php foreach ($produks as $produk): ?>
                            <option value="<?php echo $produk['id_produk']; ?>" data-harga="<?php echo $produk['harga_satuan']; ?>"><?php echo $produk['nama_produk']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="order-7">
                    <label for="harga_per_item" class="block text-sm font-medium text-gray-700">Harga Per Item</label>
                    <input type="number" id="harga_per_item" name="harga_per_item" class="form-input w-full bg-gray-100" required readonly>
                </div>
                <div class="order-9">
                    <label for="jumlah_produk" class="block text-sm font-medium text-gray-700">Jumlah Produk</label>
                    <input type="number" id="jumlah_produk" name="jumlah_produk" class="form-input w-full" required>
                </div>

                <!-- Kolom Kanan -->
                <div class="order-2">
                    <label for="diskon" class="block text-sm font-medium text-gray-700">Diskon</label>
                    <select id="diskon" name="id_diskon" class="form-input w-full">
                        <option value="">Pilih Diskon</option>
                    </select>
                </div>
                <div class="order-4">
                    <label for="pajak" class="block text-sm font-medium text-gray-700">Pajak (%)</label>
                    <input type="number" id="pajak" name="pajak" class="form-input w-full" min="0">
                </div>
                <div class="order-6">
                    <label for="total_bayar" class="block text-sm font-medium text-gray-700">Total Bayar</label>
                    <input type="number" id="total_bayar" name="total_bayar" class="form-input w-full bg-gray-100" readonly>
                </div>
                <div class="order-8">
                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" class="form-input w-full">
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="kartu_kredit">Kartu Kredit</option>
                    </select>
                </div>
                <div class="order-10">
                    <label for="status_penjualan" class="block text-sm font-medium text-gray-700">Status Penjualan</label>
                    <select id="status_penjualan" class="form-input w-full">
                        <option value="berhasil">Berhasil</option>
                        <option value="pending">Pending</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="order-11 col-span-2">
                    <label for="catatan_penjualan" class="block text-sm font-medium text-gray-700">Catatan Penjualan</label>
                    <textarea id="catatan_penjualan" name="catatan_penjualan" class="form-input w-full" rows="4"></textarea>
                </div>
                <div class="order-3">
                    <label for="tanggal_penjualan" class="block text-sm font-medium text-gray-700">Tanggal Penjualan</label>
                    <input type="date" name="tanggal_jual" id="tanggal_penjualan" class="form-input w-full" required>
                </div>
            </div>

            <!-- Button Simpan -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="btn-primary px-6 py-2 font-semibold" name="simpan">
                    Simpan
                </button>
            </div>
        </form>
    </section>

</div>


<script>
    function populateDiscounts(tanggalPenjualan) {
        const hargaPerItem = parseFloat(hargaPerItemInput.value) || 0;
        const jumlahProduk = parseInt(jumlahProdukInput.value) || 0;
        let totalPembelian = hargaPerItem * jumlahProduk;
        totalPembelian += totalPembelian * (ppn.value / 100);

        fetch(`/controller/getDiskon.php?date=${tanggalPenjualan}&total=${totalPembelian}`)
            .then(response => response.json())
            .then(data => {
                diskonSelect.innerHTML = '<option value="">Pilih Diskon</option>'; // Clear previous options
                data.forEach(discount => {
                    const option = document.createElement('option');
                    option.setAttribute('value', discount.id_diskon);
                    option.text = `${discount.nama_diskon} (${discount.persentase}% off, max Rp ${discount.batasan_harga})`;
                    option.dataset.persentase = discount.persentase;
                    option.dataset.batasanDiskon = discount.batasan_harga;
                    option.dataset.minimalPembelian = discount.minimal_pembelian;
                    diskonSelect.appendChild(option);
                });
            }).catch(error => {
                console.error('Error:', error);
            });
    }

    const namaProdukSelect = document.getElementById('nama_produk');
    const hargaPerItemInput = document.getElementById('harga_per_item');
    const jumlahProdukInput = document.getElementById('jumlah_produk');
    const diskonSelect = document.getElementById('diskon');
    const totalPembelianInput = document.getElementById('total_bayar');
    const tanggalPenjualanInput = document.getElementById('tanggal_penjualan');
    tanggalPenjualanInput.addEventListener('change', function(e) {
        populateDiscounts(e.target.value);
    })
    const ppn = document.getElementById('pajak'); // 10% PPN

    function updateTotalPembelian() {
        const hargaPerItem = parseFloat(hargaPerItemInput.value) || 0;
        const jumlahProduk = parseInt(jumlahProdukInput.value) || 0;
        let totalPembelian = hargaPerItem * jumlahProduk;
        totalPembelian += totalPembelian * (ppn.value / 100);

        const selectedDiscount = diskonSelect.options[diskonSelect.selectedIndex].dataset;
        if (selectedDiscount.persentase && selectedDiscount.batasanDiskon && selectedDiscount.minimalPembelian) {
            if (totalPembelian >= parseFloat(selectedDiscount.minimalPembelian)) {
                const discountAmount = Math.min(totalPembelian * (selectedDiscount.persentase / 100), selectedDiscount.batasanDiskon);
                totalPembelian -= discountAmount;
            }
        }

        totalPembelianInput.setAttribute('value', totalPembelian);

        console.log("hargaPerItem", hargaPerItem);
        console.log("jumlahProduk", jumlahProduk);
        console.log("totalPembelian", totalPembelian);
    }

    namaProdukSelect.addEventListener('change', function() {
        const selectedOption = namaProdukSelect.options[namaProdukSelect.selectedIndex];
        const harga = selectedOption.dataset.harga || 0;
        hargaPerItemInput.setAttribute('value', harga);
        updateTotalPembelian();
        populateDiscounts(tanggalPenjualanInput.value);
    });

    hargaPerItemInput.addEventListener('input', function() {
        updateTotalPembelian();
        populateDiscounts(tanggalPenjualanInput.value);
    });

    jumlahProdukInput.addEventListener('input', function() {
        updateTotalPembelian();
        populateDiscounts(tanggalPenjualanInput.value);
    });

    ppn.addEventListener('input', function() {
        updateTotalPembelian();
        populateDiscounts(tanggalPenjualanInput.value);
    });

    diskonSelect.addEventListener('change', updateTotalPembelian);

    tanggalPenjualanInput.addEventListener('change', function(e) {
        populateDiscounts(e.target.value);
    });

    if (tanggalPenjualanInput.value) {
        populateDiscounts(tanggalPenjualanInput.value);
    }
</script>