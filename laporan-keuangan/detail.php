<?php
$active = 'keuangan';
include '../components/header.php';

include '../controller/LaporanKeuangan.php';
$laporanKeuangan = getDetailLaporanKeuangan($_GET['id']);
?>


<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Laporan Keuangan';
    include '../components/header-main.php';

    ?>

    <!-- Financial Report Section -->
    <div class="grid grid-cols-2 gap-4 mb-6">

        <!-- Periode -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-gray-800">Periode</h3>
            <div class="mt-2 flex items-center gap-2">
                <input type="text" disabled id="from-date" class="border border-gray-300 rounded p-2 flex-1" value="<?= date('j F Y', strtotime($laporanKeuangan['laporan_keuangan']['periode_mulai'])) ?>">
                <span class="text-gray-600 font-semibold">-</span>
                <input type="text" disabled id="to-date" class="border border-gray-300 rounded p-2 flex-1" value="<?= date('j F Y', strtotime($laporanKeuangan['laporan_keuangan']['periode_selesai'])) ?>">
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-gray-800">Total Pendapatan</h3>
            <p class="text-lg font-semibold mt-2 text-green-500" id="total-pendapatan">Rp. <?= number_format($laporanKeuangan['total_pendapatan'], 0, ',', '.') ?></p>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-gray-800">Total Pengeluaran</h3>
            <p class="text-lg font-semibold mt-2 text-red-500" id="total-pengeluaran">Rp. <?= number_format($laporanKeuangan['total_pengeluaran'], 0, ',', '.') ?></p>
        </div>

        <!-- Biaya Operasional -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-gray-800">Biaya Operasional</h3>
            <p class="text-lg font-semibold mt-2 text-blue-500" id="biaya-operasional">Rp. <?= number_format($laporanKeuangan['biaya_operasional'], 0, ',', '.') ?></p>
        </div>

        <!-- Total Laba Bersih -->
        <div class="bg-white p-4 rounded shadow col-span-2">
            <h3 class="font-bold text-gray-800">Total Laba Bersih</h3>
            <p class="text-lg font-semibold mt-2 text-yellow-500" id="total-laba">Rp. <?= number_format($laporanKeuangan['total_laba_bersih'], 0, ',', '.') ?></p>
        </div>

    </div>

    <!-- Description Section -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold text-gray-800">Deskripsi</h3>
        <textarea class="mt-2 w-full border border-gray-300 rounded p-2" disabled rows="5" placeholder="Masukkan deskripsi laporan"><?= $laporanKeuangan['laporan_keuangan']['deskripsi'] ?></textarea>
    </div>
</div>
<?php
include '../components/footer.php';
?>