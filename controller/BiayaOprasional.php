<?php
include 'koneksi.php';

function tambahBiayaOperasional($data)
{
    // total_biaya	deskripsi	jenis_biaya	tanggal
    global $conn;
    $id_laporan = htmlspecialchars($data['id_laporan']);
    $total_biaya = htmlspecialchars($data['total_biaya']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $jenis_biaya = htmlspecialchars($data['jenis_biaya']);
    $tanggal = htmlspecialchars($data['tanggal']);

    $query = "INSERT INTO biaya_operasional (id_laporan, total_biaya, deskripsi, jenis_biaya, tanggal) VALUES ('$id_laporan', '$total_biaya', '$deskripsi', '$jenis_biaya', '$tanggal')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function getBiayaOperasional()
{
    global $conn;
    $query = "SELECT b.*, l.periode_mulai, l.periode_selesai 
              FROM biaya_operasional b 
              JOIN laporan_keuangan l ON b.id_laporan = l.id_laporan ORDER BY id_biaya_opersional DESC";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function getBiayaOperasionalById($id)
{
    global $conn;
    $query = "SELECT * FROM biaya_operasional WHERE id_biaya_opersional = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateBiayaOperasional($data)
{
    global $conn;
    $id_biaya_opersional = $data['id_biaya_opersional'];
    $id_laporan = htmlspecialchars($data['id_laporan']);
    $total_biaya = htmlspecialchars($data['total_biaya']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $jenis_biaya = htmlspecialchars($data['jenis_biaya']);
    $tanggal = htmlspecialchars($data['tanggal']);

    $query = "UPDATE biaya_operasional SET id_laporan = '$id_laporan', total_biaya = '$total_biaya', deskripsi = '$deskripsi', jenis_biaya = '$jenis_biaya', tanggal = '$tanggal' WHERE id_biaya_opersional = $id_biaya_opersional";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function deleteBiayaOperasional($id)
{
    global $conn;
    $query = "DELETE FROM biaya_operasional WHERE id_biaya_opersional = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function searchBiayaOperasional($keyword)
{
    global $conn;
    $query = "SELECT b.*, l.periode_mulai, l.periode_selesai 
              FROM biaya_operasional b 
              JOIN laporan_keuangan l ON b.id_laporan = l.id_laporan
              WHERE b.jenis_biaya LIKE '%$keyword%' OR b.total_biaya LIKE '%$keyword%' OR b.deskripsi LIKE '%$keyword%' OR b.tanggal LIKE '%$keyword%' ORDER BY id_biaya_opersional DESC";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}