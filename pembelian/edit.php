<?php
$active = 'pembelian';
include '../components/header.php';

include '../controller/LaporanKeuangan.php';
$laporanKeuangan = getLaporanKeuangan();

include '../controller/pembelian.php';

$pembelian = getPembelianById($_GET['id']);

if (isset($_POST['update'])) {
    $data = [
        'id_pembelian' => $_POST['id_pembelian'],
        'id_laporan_keuangan' => $_POST['id_laporan_keuangan'],
        'nama_barang' => $_POST['nama_barang'],
        'harga_perbarang' => $_POST['harga_perbarang'],
        'jumlah_barang' => $_POST['jumlah_barang'],
        'tanggal_beli' => $_POST['tanggal_beli'],
        'status_pembelian' => $_POST['status_pembelian'],
        'metode_pembayaran' => $_POST['metode_pembayaran'],
        'status_pembayaran' => $_POST['status_pembayaran'],
        'catatan_pembelian' => $_POST['catatan_pembelian']
    ];

    $result = updatePembelian($data);

    if ($result > 0) {
        echo "<script>
            alert('Data berhasil diupdate!');
            window.location.href = '/pembelian';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diupdate!');
            window.location.href = '/pembelian/edit.php?id=" . $_POST['id_pembelian'] . "';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">
    <?php

    $titleMain = 'Edit Pembelian';
    include '../components/header-main.php';
    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form id="tambah-pembelian-form" action="/pembelian/edit.php?id=<?php echo $pembelian['id_pembelian']; ?>" method="post">
            <input type="hidden" name="id_pembelian" value="<?php echo $pembelian['id_pembelian']; ?>">
            <div class="grid grid-cols-1 gap-6">
                <div class="order-">
                    <label for="laporan_keuangan" class="block text-sm font-medium text-gray-700">Laporan Keuangan</label>
                    <select id="laporan_keuangan" class="form-input w-full" name="id_laporan_keuangan">
                        <option>Pilih Laporan Keuangan</option>
                        <?php foreach ($laporanKeuangan as $laporan): ?>
                            <option value="<?php echo $laporan['id_laporan']; ?>" <?php echo $laporan['id_laporan'] == $pembelian['id_laporan_keuangan'] ? 'selected' : ''; ?>>
                                <?php echo date('j F Y', strtotime($laporan['periode_mulai'])) . ' - ' . date('j F Y', strtotime($laporan['periode_selesai'])); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="order-">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" id="nama_barang" class="form-input w-full" name="nama_barang" value="<?php echo $pembelian['nama_barang']; ?>" required>
                </div>
                <div class="order-">
                    <label for="harga_perbarang" class="block text-sm font-medium text-gray-700">Harga Per Barang</label>
                    <input type="number" id="harga_perbarang" class="form-input w-full" name="harga_perbarang" value="<?php echo (int)$pembelian['harga_perbarang']; ?>" required>
                </div>
                <div class="order-">
                    <label for="jumlah_barang" class="block text-sm font-medium text-gray-700">Jumlah Barang</label>
                    <input type="number" id="jumlah_barang" class="form-input w-full" name="jumlah_barang" value="<?php echo $pembelian['jumlah_barang']; ?>" required>
                </div>
                <div class="order-">
                    <label class="block text-sm font-medium text-gray-700">Total Pembelian</label>
                    <input type="number" class="form-input w-full bg-gray-100" disabled id="total_pembelian" value="<?php echo (int)$pembelian['total_pembelian'] ?>">
                </div>
                <div class="order-">
                    <label for="tanggal_pembelian" class="block text-sm font-medium text-gray-700">Tanggal Pembelian</label>
                    <input type="date" id="tanggal_pembelian" class="form-input w-full" name="tanggal_beli" value="<?php echo $pembelian['tanggal_beli']; ?>" required>
                </div>
                <div class="order-">
                    <label for="status_pembelian" class="block text-sm font-medium text-gray-700">Status Pembelian</label>
                    <select id="status_pembelian" class="form-input w-full" name="status_pembelian">
                        <option value="Inden" <?php echo $pembelian['status_pembelian'] == 'Inden' ? 'selected' : ''; ?>>Inden</option>
                        <option value="Ada" <?php echo $pembelian['status_pembelian'] == 'Ada' ? 'selected' : ''; ?>>Ada</option>
                    </select>
                </div>
                <div class="order-">
                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select id="metode_pembayaran" class="form-input w-full" name="metode_pembayaran">
                        <option value="Transfer Bank" <?php echo $pembelian['metode_pembayaran'] == 'Transfer Bank' ? 'selected' : ''; ?>>Transfer Bank</option>
                        <option value="Kartu Kredit" <?php echo $pembelian['metode_pembayaran'] == 'Kartu Kredit' ? 'selected' : ''; ?>>Kartu Kredit</option>
                        <option value="Cash on Delivery" <?php echo $pembelian['metode_pembayaran'] == 'Cash on Delivery' ? 'selected' : ''; ?>>Cash on Delivery</option>
                        <option value="E-Wallet" <?php echo $pembelian['metode_pembayaran'] == 'E-Wallet' ? 'selected' : ''; ?>>E-Wallet</option>
                    </select>
                </div>
                <div class="order-">
                    <label for="status_pembayaran" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                    <select id="status_pembayaran" class="form-input w-full" name="status_pembayaran">
                        <option value="Lunas" <?php echo $pembelian['status_pembayaran'] == 'Lunas' ? 'selected' : ''; ?>>Lunas</option>
                        <option value="Belum Lunas" <?php echo $pembelian['status_pembayaran'] == 'Belum Lunas' ? 'selected' : ''; ?>>Belum Lunas</option>
                        <option value="Refund" <?php echo $pembelian['status_pembayaran'] == 'Refund' ? 'selected' : ''; ?>>Refund</option>
                    </select>
                </div>
                <div class="order-">
                    <label for="catatan_pembelian" class="block text-sm font-medium text-gray-700">Catatan Pembelian</label>
                    <textarea id="catatan_pembelian" class="form-input w-full" name="catatan_pembelian" rows="4"><?php echo $pembelian['catatan_pembelian']; ?></textarea>
                </div>
            </div>

            <!-- Button Simpan -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="btn-primary px-6 py-2 font-semibold" name="update">Simpan</button>
            </div>
        </form>
    </section>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hargaPerBarangInput = document.getElementById('harga_perbarang');
        const jumlahBarangInput = document.getElementById('jumlah_barang');
        const totalPembelianInput = document.getElementById('total_pembelian');

        function updateTotalPembelian() {
            const hargaPerBarang = parseFloat(hargaPerBarangInput.value) || 0;
            const jumlahBarang = parseInt(jumlahBarangInput.value) || 0;
            const totalPembelian = hargaPerBarang * jumlahBarang;
            totalPembelianInput.value = totalPembelian;
        }

        hargaPerBarangInput.addEventListener('input', updateTotalPembelian);
        jumlahBarangInput.addEventListener('input', updateTotalPembelian);
    });
</script>