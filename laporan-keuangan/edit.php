<?php
$active = 'keuangan';
include '../components/header.php';

include '../controller/LaporanKeuangan.php';
$id = $_GET['id'];
$dataLaporanKeuangan = getLaporanKeuanganById($id);

if (isset($_POST['update'])) {
    $result = updateLaporanKeuangan($_POST);
    if ($result > 0) {
        echo "<script>
            alert('Data berhasil diupdate!');
            window.location.href = '/laporan-keuangan';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diupdate!');
            window.location.href = '/laporan-keuangan';
        </script>";
    }
}

if (isset($_POST['deleteLaporanKeuangan'])) {
    $id = $_POST['id'];
    $result = deleteLaporanKeuangan($id);
    if ($result > 0) {
        echo "<script>
            alert('Laporan keuangan berhasil dihapus!');
            window.location.href = '/laporan-keuangan';
        </script>";
    } else {
        echo "<script>
            alert('Laporan keuangan gagal dihapus!');
            window.location.href = '/laporan-keuangan';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">
    <?php

    $titleMain = 'Edit Keuangan';
    include '../components/header-main.php';
    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form id="tambah-pembelian-form" action="/laporan-keuangan/edit.php?id=<?php echo $dataLaporanKeuangan['id_laporan']; ?>" method="post">
            <!-- deskripsi	periode_mulai	periode_selesai -->
            <div class="grid grid-cols-2 gap-6">
                <input type="hidden" name="id_laporan" value="<?= $dataLaporanKeuangan['id_laporan'] ?>">
                <div class="order-1">
                    <label for="periode_mulai" class="block text-sm font-medium text-gray-700">Periode Mulai</label>
                    <input type="date" id="periode_mulai" name="periode_mulai" class="form-input w-full" value="<?php echo $dataLaporanKeuangan['periode_mulai']; ?>" required>
                </div>
                <div class="order-2">
                    <label for="periode_selesai" class="block text-sm font-medium text-gray-700">Periode Selesai</label>
                    <input type="date" id="periode_selesai" name="periode_selesai" class="form-input w-full" value="<?php echo $dataLaporanKeuangan['periode_selesai']; ?>" required>
                </div>
                <div class="order-3 col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-input w-full" rows="4"><?php echo $dataLaporanKeuangan['deskripsi']; ?></textarea>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="btn-primary px-6 py-2 font-semibold" name="update">Simpan</button>
            </div>
        </form>
    </section>

</div>