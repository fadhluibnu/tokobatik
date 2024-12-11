<?php
$active = 'operasional';
include '../components/header.php';

include '../controller/LaporanKeuangan.php';
$laporanKeuangan = getLaporanKeuangan();

if (isset($_POST['submit'])) {
    include '../controller/BiayaOprasional.php';

    $data = [
        'id_laporan' => $_POST['id_laporan'],
        'total_biaya' => $_POST['total_biaya'],
        'deskripsi' => $_POST['deskripsi'],
        'jenis_biaya' => $_POST['jenis_biaya'],
        'tanggal' => $_POST['tanggal']
    ];

    $result = tambahBiayaOperasional($data);

    if ($result > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            window.location.href = '/biaya-operasional';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            window.location.href = '/biaya-operasional/tambah.php';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">
    <?php

    $titleMain = 'Tambah Pembelian';
    include '../components/header-main.php';
    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form id="tambah-pembelian-form" action="/biaya-operasional/tambah.php" method="post">
            <div class="grid grid-cols-1 gap-6">
                <div class="order-">
                    <label for="laporan_keuangan" class="block text-sm font-medium text-gray-700">Laporan Keuangan</label>
                    <select id="laporan_keuangan" class="form-input w-full" name="id_laporan">
                        <option>Pilih Laporan Keuangan</option>
                        <?php foreach ($laporanKeuangan as $laporan): ?>
                            <option value="<?php echo $laporan['id_laporan']; ?>">
                                <?php echo date('j F Y', strtotime($laporan['periode_mulai'])) . ' - ' . date('j F Y', strtotime($laporan['periode_selesai'])); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="order-">
                    <label for="jenis_biaya" class="block text-sm font-medium text-gray-700">Jenis Biaya</label>
                    <input type="text" id="jenis_biaya" name="jenis_biaya" class="form-input w-full" required>
                </div>
                <div class="order-">
                    <label for="total_biaya" class="block text-sm font-medium text-gray-700">Total Biaya</label>
                    <input type="number" id="total_biaya" name="total_biaya" class="form-input w-full" required>
                </div>
                <div class="order-">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-input w-full" rows="3" required></textarea>
                </div>
                <div class="order-">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-input w-full" required>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="btn-primary px-6 py-2 font-semibold" name="submit">Tambah Pembelian</button>
            </div>
        </form>
    </section>

</div>