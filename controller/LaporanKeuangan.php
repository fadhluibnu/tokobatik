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
    $query = "SELECT * FROM laporan_keuangan";
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
              OR DATE(periode_selesai) = '$safeKeyword'";

    $result = mysqli_query($conn, $query);

    // Mengumpulkan hasil pencarian
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}
