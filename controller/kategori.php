<?php

include 'koneksi.php';

function tambahKategori($data)
{
  global $conn;
  $nama_kategori = htmlspecialchars($data['nama_kategori']);
  $deskripsi_produk = htmlspecialchars($data['deskripsi_produk']);
  $tanggal_dibuat = date('Y-m-d H:i:s');

  if ($nama_kategori == '' || $deskripsi_produk == '') {
    return false;
  }

  $query = "INSERT INTO kategori_produk (nama_kategori, deskripsi_produk, tanggal_dibuat) VALUES ('$nama_kategori', '$deskripsi_produk', '$tanggal_dibuat')";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function getKategori()
{
  global $conn;
  $query = "SELECT * FROM kategori_produk";
  $result = mysqli_query($conn, $query);
  $data = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
  return $data;
}

function getKategoriById($id)
{
  global $conn;
  $query = "SELECT * FROM kategori_produk WHERE id_kategori_produk = $id";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_assoc($result);
}

function updateKategori($data)
{
  global $conn;
  $id_kategori_produk = $data['id_kategori_produk'];
  $nama_kategori = htmlspecialchars($data['nama_kategori']);
  $deskripsi_produk = htmlspecialchars($data['deskripsi_produk']);

  if ($nama_kategori == '' || $deskripsi_produk == '') {
    return false;
  }

  $query = "UPDATE kategori_produk SET nama_kategori = '$nama_kategori', deskripsi_produk = '$deskripsi_produk' WHERE id_kategori_produk = $id_kategori_produk";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function deleteKategori($id)
{
  global $conn;
  $query = "DELETE FROM kategori_produk WHERE id_kategori_produk = $id";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function searchKategori($keyword)
{
  global $conn;
  $query = "SELECT * FROM kategori_produk WHERE nama_kategori LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%'";
  $result = mysqli_query($conn, $query);
  $data = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
  return $data;
}