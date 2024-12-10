<?php

include 'koneksi.php';

// tambah diskon
function tambahDiskon($data)
{
    global $conn;

    $nama_diskon = htmlspecialchars($data['nama_diskon']);
    $periode_mulai = htmlspecialchars($data['periode_mulai']);
    $periode_selesai = htmlspecialchars($data['periode_selesai']);
    $persentase = htmlspecialchars($data['persentase']);
    $batasan_harga = htmlspecialchars($data['batasan_harga']);
    $minimal_pembelian = htmlspecialchars($data['minimal_pembelian']);

    $query = "INSERT INTO diskon VALUES ('', '$nama_diskon', '$periode_mulai', '$periode_selesai', '$persentase', '$batasan_harga', '$minimal_pembelian')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// select diskon
function getDiskon()
{
    global $conn;
    $query = "SELECT * FROM diskon";
    $result = mysqli_query($conn, $query);
    $dataDiskon = [];
    while ($diskon = mysqli_fetch_assoc($result)) {
        $dataDiskon[] = $diskon;
    }
    return $dataDiskon;
}

// get by id
function getDiskonById($id)
{
    global $conn;
    $query = "SELECT * FROM diskon WHERE id_diskon = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}


// edit diskon
function editDiskon($data)
{
    global $conn;

    $id_diskon = $data['id_diskon'];
    $nama_diskon = htmlspecialchars($data['nama_diskon']);
    $periode_mulai = htmlspecialchars($data['periode_mulai']);
    $periode_selesai = htmlspecialchars($data['periode_selesai']);
    $persentase = htmlspecialchars($data['persentase']);
    $batasan_harga = htmlspecialchars($data['batasan_harga']);
    $minimal_pembelian = htmlspecialchars($data['minimal_pembelian']);

    $query = "UPDATE diskon SET nama_diskon = '$nama_diskon', periode_mulai = '$periode_mulai', periode_selesai = '$periode_selesai', persentase = '$persentase', batasan_harga = '$batasan_harga', minimal_pembelian = '$minimal_pembelian' WHERE id_diskon = $id_diskon";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// delete diskon
function deleteDiskon($id)
{
    global $conn;
    $query = "DELETE FROM diskon WHERE id_diskon = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// search diskon
function searchDiskon($keyword)
{
    global $conn;
    $query = "SELECT * FROM diskon WHERE nama_diskon LIKE '%$keyword%' OR periode_mulai LIKE '%$keyword%' OR periode_selesai LIKE '%$keyword%' OR persentase LIKE '%$keyword%' OR batasan_harga LIKE '%$keyword%' OR minimal_pembelian LIKE '%$keyword%'";
    $result = mysqli_query($conn, $query);
    $dataDiskon = [];
    while ($diskon = mysqli_fetch_assoc($result)) {
        $dataDiskon[] = $diskon;
    }
    return $dataDiskon;
}