<?php
$active = 'pembelian';
include '../components/header.php';

include '../controller/LaporanKeuangan.php';
$laporanKeuangan = getLaporanKeuangan();

include '../controller/BiayaOprasional.php';
$id = $_GET['id'];
$biayaOperasional = getBiayaOperasionalById($id);

if (isset($_POST['update'])) {
    $data = [
        'id_biaya_opersional' => $_POST['id_biaya_operasional'],
        'id_laporan' => $_POST['id_laporan'],
        'total_biaya' => $_POST['total_biaya'],
        'deskripsi' => $_POST['deskripsi'],
        'jenis_biaya' => $_POST['jenis_biaya'],
        'tanggal' => $_POST['tanggal']
    ];

    $result = updateBiayaOperasional($data);

    if ($result > 0) {
        echo "<script>
            alert('Data berhasil diupdate!');
            window.location.href = '/biaya-operasional';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diupdate!');
            window.location.href = '/biaya-operasional/edit.php?id=$id';
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
        <form id="edit-pembelian-form" method="POST" action="../biaya-operasional/edit.php?id=<?php echo $biayaOperasional['id_biaya_opersional']; ?>">
            <div class="grid grid-cols-1 gap-6">
                <input type="hidden" name="id_biaya_operasional" value="<?php echo $biayaOperasional['id_biaya_opersional']; ?>">
                <div class="order-">
                    <label for="laporan_keuangan" class="block text-sm font-medium text-gray-700">Laporan Keuangan</label>
                    <select id="laporan_keuangan" class="form-input w-full" name="id_laporan">
                        <option>Pilih Laporan Keuangan</option>
                        <?php foreach ($laporanKeuangan as $laporan): ?>
                            <option value="<?php echo $laporan['id_laporan']; ?>" <?php echo $laporan['id_laporan'] == $biayaOperasional['id_laporan'] ? 'selected' : ''; ?>>
                                <?php echo date('j F Y', strtotime($laporan['periode_mulai'])) . ' - ' . date('j F Y', strtotime($laporan['periode_selesai'])); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="order-">
                    <label for="jenis_biaya" class="block text-sm font-medium text-gray-700">Jenis Biaya</label>
                    <input type="text" id="jenis_biaya" name="jenis_biaya" class="form-input w-full" value="<?php echo $biayaOperasional['jenis_biaya']; ?>" required>
                </div>
                <div class="order-">
                    <label for="total_biaya" class="block text-sm font-medium text-gray-700">Total Biaya</label>
                    <input type="number" id="total_biaya" name="total_biaya" class="form-input w-full" value="<?php echo (int)$biayaOperasional['total_biaya']; ?>" required>
                </div>
                <div class="order-">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-input w-full" rows="3" required><?php echo $biayaOperasional['deskripsi']; ?></textarea>
                </div>
                <div class="order-">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-input w-full" value="<?php echo $biayaOperasional['tanggal']; ?>" required>
                </div>
                <div class="order-">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" name="update">Update Pembelian</button>
                </div>
            </div>
        </form>
    </section>

</div>