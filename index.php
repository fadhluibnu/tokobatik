<?php
$active = 'dashboard';
include 'components/header.php';

include 'controller/dashboard.php';
$laporan = laporan();
?>

<!-- Main Content -->
<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Produk';
    include 'components/header-main.php';

    ?>

    <!-- Cards Section -->
    <section class="cards">
        <button class="card bg-blue-500">Total Penjualan <br> Rp. <?= number_format($laporan['total_penjualan'], 0, ',', '.') ?></button>
        <button class="card bg-green-500">Total Pembelian <br> Rp. <?= number_format($laporan['total_pembelian'], 0, ',', '.') ?></button>
        <button class="card bg-yellow-500">Laba Bersih <br> Rp. <?= number_format($laporan['total_laba_bersih'], 0, ',', '.') ?></button>
        <button class="card bg-red-500">Total Stok Produk <br> <?= number_format($laporan['total_stok_produk'], 0, ',', '.') ?></button>
    </section>

    <!-- Transactions Section -->
    <section class="transactions">
        <div class="data-box">
            <h3>Transaksi Terbaru</h3>
            <div class="placeholder">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Tanggal</th>
                            <th class="border px-4 py-2">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach (transaksiTerbaru() as $transaksi) {
                        ?>
                            <tr>
                                <td class="border px-4 py-2"><?= $no++ ?></td>
                                <td class="border px-4 py-2"><?= date('d F Y', strtotime($transaksi['tanggal_jual'])) ?></td>
                                <td class="border px-4 py-2">Rp. <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Graphs and Data Section -->
    <section class="mt-6">
        <div class="data-box">
            <h3>Status Stok Produk</h3>
            <div class="placeholder">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Kode Produk</th>
                            <th class="border px-4 py-2">Nama Produk</th>
                            <th class="border px-4 py-2">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach (statusProduk() as $produk) {
                        ?>
                            <tr>
                                <td class="border px-4 py-2"><?= $no++ ?></td>
                                <td class="border px-4 py-2"><?= $produk['kode_produk'] ?></td>
                                <td class="border px-4 py-2"><?= $produk['nama_produk'] ?></td>
                                <td class="border px-4 py-2"><?= $produk['stok'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php
include 'components/footer.php';
?>