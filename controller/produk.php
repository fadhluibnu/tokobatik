<?php

include 'koneksi.php';

function tambahProduk($data)
{
    // id_produk	nama_produk	kode_produk	deskripsi_produk	berat_produk	harga_satuan	stok	id_kategori_produk	unit_satuan	lokasi_penyimpanan	status_aktif	dimensi_produk
    global $conn;
    $nama_produk = htmlspecialchars($data['nama_produk']);
    $kode_produk = htmlspecialchars($data['kode_produk']);
    $deskripsi_produk = htmlspecialchars($data['deskripsi_produk']);
    $berat_produk = htmlspecialchars($data['berat_produk']);
    $harga_satuan = htmlspecialchars($data['harga_satuan']);
    $stok = htmlspecialchars($data['stok']);
    $id_kategori_produk = htmlspecialchars($data['id_kategori_produk']);
    $lokasi_penyimpanan = htmlspecialchars($data['lokasi_penyimpanan']);
    $status_aktif = htmlspecialchars($data['status_aktif']);
    $dimensi_produk = htmlspecialchars($data['dimensi_produk']);
    $image = $data['image'];

    $query = "INSERT INTO produk (nama_produk, kode_produk, deskripsi_produk, berat_produk, harga_satuan, stok, id_kategori_produk, lokasi_penyimpanan, status_aktif, dimensi_produk, image) VALUES ('$nama_produk', '$kode_produk', '$deskripsi_produk', '$berat_produk', '$harga_satuan', '$stok', '$id_kategori_produk', '$lokasi_penyimpanan', '$status_aktif', '$dimensi_produk', '$image')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function getProduk()
{
    global $conn;
    $query = "SELECT produk.*, kategori_produk.nama_kategori FROM produk JOIN kategori_produk ON produk.id_kategori_produk = kategori_produk.id_kategori_produk";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function getProdukById($id)
{
    global $conn;
    $query = "SELECT produk.*, kategori_produk.nama_kategori FROM produk JOIN kategori_produk ON produk.id_kategori_produk = kategori_produk.id_kategori_produk WHERE id_produk = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateProduk($data)
{
    global $conn;
    $id_produk = $data['id_produk'];
    $nama_produk = htmlspecialchars($data['nama_produk']);
    $kode_produk = htmlspecialchars($data['kode_produk']);
    $deskripsi_produk = htmlspecialchars($data['deskripsi_produk']);
    $berat_produk = htmlspecialchars($data['berat_produk']);
    $harga_satuan = htmlspecialchars($data['harga_satuan']);
    $stok = htmlspecialchars($data['stok']);
    $id_kategori_produk = htmlspecialchars($data['id_kategori_produk']);
    $lokasi_penyimpanan = htmlspecialchars($data['lokasi_penyimpanan']);
    $status_aktif = htmlspecialchars($data['status_aktif']);
    $dimensi_produk = htmlspecialchars($data['dimensi_produk']);
    $image = $data['image'];

    $query = "UPDATE produk SET nama_produk = '$nama_produk', kode_produk = '$kode_produk', deskripsi_produk = '$deskripsi_produk', berat_produk = '$berat_produk', harga_satuan = '$harga_satuan', stok = '$stok', id_kategori_produk = '$id_kategori_produk', lokasi_penyimpanan = '$lokasi_penyimpanan', status_aktif = '$status_aktif', dimensi_produk = '$dimensi_produk', image = '$image' WHERE id_produk = $id_produk";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function deleteProduk($id)
{
    global $conn;
    $query = "DELETE FROM produk WHERE id_produk = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function searchProduk($keyword)
{
    global $conn;
    $query = "SELECT produk.*, kategori_produk.nama_kategori FROM produk JOIN kategori_produk ON produk.id_kategori_produk = kategori_produk.id_kategori_produk WHERE nama_produk LIKE '%$keyword%' OR kode_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%'";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}
