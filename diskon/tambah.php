<?php
$active = 'diskon';
include '../components/header.php';

include '../controller/diskon.php';
if (isset($_POST['submit'])) {
    $data = [
        'nama_diskon' => $_POST['nama_diskon'],
        'periode_mulai' => $_POST['periode_mulai'],
        'periode_selesai' => $_POST['periode_selesai'],
        'persentase' => $_POST['persentase'],
        'batasan_harga' => $_POST['batasan_harga'],
        'minimal_pembelian' => $_POST['minimal_pembelian']
    ];
    $result = tambahDiskon($data);
    if ($result > 0) {
        echo "<script>
            alert('Diskon berhasil ditambahkan!');
            window.location.href = '/diskon';
        </script>";
    } else {
        echo "<script>
            alert('Diskon gagal ditambahkan!');
            window.location.href = '/diskon';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">

    <?php

    $titleMain = 'Tambah Diskon';
    include '../components/header-main.php';

    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form class="space-y-4" id="tambah-produk-form" action="/diskon/tambah.php" method="post">
            <div>
                <label for="nama_diskon" class="block text-sm font-medium text-gray-700">Nama Diskon</label>
                <input type="text" name="nama_diskon" id="nama_diskon" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="periode_mulai" class="block text-sm font-medium text-gray-700">Periode Mulai</label>
                <input type="date" name="periode_mulai" id="periode_mulai" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="periode_selesai" class="block text-sm font-medium text-gray-700">Periode Selesai</label>
                <input type="date" name="periode_selesai" id="periode_selesai" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="persentase" class="block text-sm font-medium text-gray-700">Persentase</label>
                <input type="number" name="persentase" id="persentase" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="batasan_harga" class="block text-sm font-medium text-gray-700">Batasan Harga</label>
                <input type="number" name="batasan_harga" id="batasan_harga" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="minimal_pembelian" class="block text-sm font-medium text-gray-700">Minimal Pembelian</label>
                <input type="number" name="minimal_pembelian" id="minimal_pembelian" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-md" name="submit">Tambah Diskon</button>
            </div>
        </form>
    </section>

</div>