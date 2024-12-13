<?php
include 'koneksi.php';

function tambahLaporanKeuangan($data)
{
    // deskripsi	periode_mulai	periode_selesai
    global $conn;
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $periode_mulai = htmlspecialchars($data['periode_mulai']);
    $periode_selesai = htmlspecialchars($data['periode_selesai']);

    $query = "INSERT INTO laporan_keuangan (deskripsi, periode_mulai, periode_selesai) VALUES ('$deskripsi', '$periode_mulai', '$periode_selesai')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function getLaporanKeuangan()
{
    global $conn;
    $query = "SELECT * FROM laporan_keuangan ORDER BY id_laporan DESC";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function getLaporanKeuanganById($id)
{
    global $conn;
    $query = "SELECT * FROM laporan_keuangan WHERE id_laporan = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateLaporanKeuangan($data)
{
    global $conn;
    $id_laporan = $data['id_laporan'];
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $periode_mulai = htmlspecialchars($data['periode_mulai']);
    $periode_selesai = htmlspecialchars($data['periode_selesai']);

    $query = "UPDATE laporan_keuangan SET deskripsi = '$deskripsi', periode_mulai = '$periode_mulai', periode_selesai = '$periode_selesai' WHERE id_laporan = $id_laporan";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function deleteLaporanKeuangan($id)
{
    global $conn;
    $query = "DELETE FROM laporan_keuangan WHERE id_laporan = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function searchLaporanKeuangan($keyword)
{
    global $conn;

    // Escape keyword untuk mencegah SQL Injection
    $safeKeyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT * FROM laporan_keuangan 
              WHERE deskripsi LIKE '%$safeKeyword%' 
              OR DATE_FORMAT(periode_mulai, '%M') LIKE '%$safeKeyword%' 
              OR DATE_FORMAT(periode_selesai, '%M') LIKE '%$safeKeyword%' 
              OR YEAR(periode_mulai) = '$safeKeyword' 
              OR YEAR(periode_selesai) = '$safeKeyword' 
              OR DATE(periode_mulai) = '$safeKeyword' 
              OR DATE(periode_selesai) = '$safeKeyword'
              ORDER BY id_laporan DESC";

    $result = mysqli_query($conn, $query);

    // Mengumpulkan hasil pencarian
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// detail laporan keuangan
function getDetailLaporanKeuangan($id)
{
    global $conn;

    // total pendapatan
    $queryPendapatan = "SELECT SUM(total_bayar) as total_pendapatan FROM penjualan WHERE id_laporan_keuangan = $id";
    $resultPendapatan = mysqli_query($conn, $queryPendapatan);
    $totalPendapatan = mysqli_fetch_assoc($resultPendapatan)['total_pendapatan'];

    // total pengeluaran
    $queryPengeluaran = "SELECT SUM(total_pembelian) as total_pengeluaran FROM pembelian WHERE id_laporan_keuangan = $id";
    $resultPengeluaran = mysqli_query($conn, $queryPengeluaran);
    $totalPengeluaran = mysqli_fetch_assoc($resultPengeluaran)['total_pengeluaran'];

    // total biaya operasional
    $queryBiayaOperasional = "SELECT SUM(total_biaya) as biaya_operasional FROM biaya_operasional WHERE id_laporan = $id";
    $resultBiayaOperasional = mysqli_query($conn, $queryBiayaOperasional);
    $BiayaOperasional = mysqli_fetch_assoc($resultBiayaOperasional)['biaya_operasional'];

    // total laba bersih
    $total_laba_bersih = $totalPendapatan - ($totalPengeluaran + $BiayaOperasional);

    // get laporan keuangan by id
    $queryLaporan = "SELECT * FROM laporan_keuangan WHERE id_laporan = $id";
    $resultLaporan = mysqli_query($conn, $queryLaporan);
    $laporan_keuangan = mysqli_fetch_assoc($resultLaporan);

    $result = [
        'total_pendapatan' => $totalPendapatan,
        'total_pengeluaran' => $totalPengeluaran,
        'biaya_operasional' => $BiayaOperasional,
        'total_laba_bersih' => $total_laba_bersih,
        'laporan_keuangan' => $laporan_keuangan
    ];

    return $result;
}
?>