<?php
include 'koneksi.php';

// tambah pembelian
// id_laporan_keuangan	total_pembelian	metode_pembayaran	status_pembelian	status_pembayaran	tanggal_beli	catatan_pembelian	harga_perbarang	nama_barang	jumlah_barang

function tambahPembelian($data)
{
    global $conn;

    $id_laporan_keuangan = $data['id_laporan_keuangan'];
    $total_pembelian = $data['harga_perbarang'] * $data['jumlah_barang'];
    $metode_pembayaran = $data['metode_pembayaran'];
    $status_pembelian = $data['status_pembelian'];
    $status_pembayaran = $data['status_pembayaran'];
    $tanggal_beli = $data['tanggal_beli'];
    $catatan_pembelian = $data['catatan_pembelian'];
    $harga_perbarang = $data['harga_perbarang'];
    $nama_barang = $data['nama_barang'];
    $jumlah_barang = $data['jumlah_barang'];

    $query = "INSERT INTO pembelian (id_laporan_keuangan, total_pembelian, metode_pembayaran, status_pembelian, status_pembayaran, tanggal_beli, catatan_pembelian, harga_perbarang, nama_barang, jumlah_barang) VALUES ('$id_laporan_keuangan', '$total_pembelian', '$metode_pembayaran', '$status_pembelian', '$status_pembayaran', '$tanggal_beli', '$catatan_pembelian', '$harga_perbarang', '$nama_barang', '$jumlah_barang')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// get pembelian
function getPembelian()
{
    global $conn;
    $query = "SELECT pembelian.*, laporan_keuangan.periode_mulai, laporan_keuangan.periode_selesai 
              FROM pembelian 
              LEFT JOIN laporan_keuangan 
              ON pembelian.id_laporan_keuangan = laporan_keuangan.id_laporan";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

// pembelian by id
function getPembelianById($id)
{
    global $conn;

    $query = "SELECT * FROM pembelian WHERE id_pembelian = $id";
    $result = mysqli_query($conn, $query);

    return mysqli_fetch_assoc($result);
}

// update pembelian
function updatePembelian($data)
{
    global $conn;

    $id_pembelian = $data['id_pembelian'];
    $id_laporan_keuangan = $data['id_laporan_keuangan'];
    $total_pembelian = $data['harga_perbarang'] * $data['jumlah_barang'];
    $metode_pembayaran = $data['metode_pembayaran'];
    $status_pembelian = $data['status_pembelian'];
    $status_pembayaran = $data['status_pembayaran'];
    $tanggal_beli = $data['tanggal_beli'];
    $catatan_pembelian = $data['catatan_pembelian'];
    $harga_perbarang = $data['harga_perbarang'];
    $nama_barang = $data['nama_barang'];
    $jumlah_barang = $data['jumlah_barang'];

    $query = "UPDATE pembelian SET id_laporan_keuangan = '$id_laporan_keuangan', total_pembelian = '$total_pembelian', metode_pembayaran = '$metode_pembayaran', status_pembelian = '$status_pembelian', status_pembayaran = '$status_pembayaran', tanggal_beli = '$tanggal_beli', catatan_pembelian = '$catatan_pembelian', harga_perbarang = '$harga_perbarang', nama_barang = '$nama_barang', jumlah_barang = '$jumlah_barang' WHERE id_pembelian = $id_pembelian";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// delete pembelian
function deletePembelian($id)
{
    global $conn;

    $query = "DELETE FROM pembelian WHERE id_pembelian = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// serach pembelian
function searchPembelian($keyword)
{
    global $conn;

    $query = "SELECT * FROM pembelian WHERE nama_barang LIKE '%$keyword%' OR harga_perbarang LIKE '%$keyword%' OR jumlah_barang LIKE '%$keyword%' OR total_pembelian LIKE '%$keyword%' OR status_pembelian LIKE '%$keyword%' OR status_pembayaran LIKE '%$keyword%' OR metode_pembayaran LIKE '%$keyword%' OR catatan_pembelian LIKE '%$keyword%' OR tanggal_beli LIKE '%$keyword%'";

    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}
