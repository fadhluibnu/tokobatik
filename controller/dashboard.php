<?php
include 'koneksi.php';

function laporan()
{

    global $conn;

    // total pendapatan
    $queryPenjualan = "SELECT SUM(total_bayar) as total_penjualan FROM penjualan";
    $resultPenjualan = mysqli_query($conn, $queryPenjualan);
    $totalPenjualan = mysqli_fetch_assoc($resultPenjualan)['total_penjualan'];

    // total pengeluaran
    $queryPembelian = "SELECT SUM(total_pembelian) as total_pembelian FROM pembelian";
    $resultPembelian = mysqli_query($conn, $queryPembelian);
    $totalPembelian = mysqli_fetch_assoc($resultPembelian)['total_pembelian'];

    // total biaya operasional
    $queryBiayaOperasional = "SELECT SUM(total_biaya) as biaya_operasional FROM biaya_operasional";
    $resultBiayaOperasional = mysqli_query($conn, $queryBiayaOperasional);
    $BiayaOperasional = mysqli_fetch_assoc($resultBiayaOperasional)['biaya_operasional'];

    // total laba bersih
    $total_laba_bersih = $totalPenjualan - ($totalPembelian + $BiayaOperasional);

    // total stok produk
    $queryStokProduk = "SELECT SUM(stok) as total_stok FROM produk";
    $resultStokProduk = mysqli_query($conn, $queryStokProduk);
    $totalStokProduk = mysqli_fetch_assoc($resultStokProduk)['total_stok'];

    $result = [
        'total_penjualan' => $totalPenjualan,
        'total_pembelian' => $totalPembelian,
        'biaya_operasional' => $BiayaOperasional,
        'total_laba_bersih' => $total_laba_bersih,
        'total_stok_produk' => $totalStokProduk
    ];

    return $result;
}

function transaksiTerbaru ()
{
    global $conn;

    $query = "SELECT * FROM penjualan ORDER BY id_penjualan DESC LIMIT 5";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

function statusProduk()
{
    // tampilkan produk yang stoknya hampir habis
    global $conn;
    $produk = "SELECT * FROM produk WHERE stok < 5";
    $result = mysqli_query($conn, $produk);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}