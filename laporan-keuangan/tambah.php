<?php
$active = 'keuangan';
include '../components/header.php';

if (isset($_POST['simpanKeuangan'])) {
    include '../controller/LaporanKeuangan.php';

    $data = [
        'deskripsi' => $_POST['deskripsi'],
        'periode_mulai' => $_POST['periode_mulai'],
        'periode_selesai' => $_POST['periode_selesai']
    ];

    $result = tambahLaporanKeuangan($data);

    if ($result > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            window.location.href = '/laporan-keuangan';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            window.location.href = '/laporan-keuangan/tambah.php';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">
    <?php

    $titleMain = 'Tambah Keuangan';
    include '../components/header-main.php';
    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form id="tambah-pembelian-form" action="/laporan-keuangan/tambah.php" method="post">
            <!-- deskripsi	periode_mulai	periode_selesai -->
            <div class="grid grid-cols-2 gap-6">
                <div class="order-1">
                    <label for="periode_mulai" class="block text-sm font-medium text-gray-700">Periode Mulai</label>
                    <input type="date" id="periode_mulai" name="periode_mulai" class="form-input w-full" required>
                </div>
                <div class="order-2">
                    <label for="periode_selesai" class="block text-sm font-medium text-gray-700">Periode Selesai</label>
                    <input type="date" id="periode_selesai" name="periode_selesai" class="form-input w-full" required>
                </div>
                <div class="order-3 col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-input w-full" rows="4"></textarea>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="btn-primary px-6 py-2 font-semibold" name="simpanKeuangan">Simpan</button>
            </div>
        </form>
    </section>

</div>