<?php

include 'koneksi.php';

// tambah penjualan
// id_laporan_keuangan id_diskon pajak total_bayar metode_pembayaran tanggal_jual catatan_penjualan id_produk jumlah_produk harga_per_item
function tambahPenjualan($data)
{
    global $conn;
    $id_laporan_keuangan = $data['id_laporan_keuangan'];
    $id_diskon = $data['id_diskon'];
    $pajak = $data['pajak'];
    $total_bayar = $data['total_bayar'];
    $metode_pembayaran = $data['metode_pembayaran'];
    $tanggal_jual = $data['tanggal_jual'];
    $catatan_penjualan = $data['catatan_penjualan'];
    $id_produk = $data['id_produk'];
    $jumlah_produk = $data['jumlah_produk'];
    $harga_per_item = $data['harga_per_item'];

    $stockQuery = "SELECT stok FROM produk WHERE id_produk = '$id_produk'";
    $stockResult = mysqli_query($conn, $stockQuery);
    $stockRow = mysqli_fetch_assoc($stockResult);
    $currentStock = $stockRow['stok'];

    if ($jumlah_produk > $currentStock) {
        echo "<script>
        alert('Jumlah produk yang dibeli melebihi stok yang tersedia.');
        window.location.href = '/penjualan/tambah.php';
    </script>";
        return 0;
    }

    $query = "INSERT INTO penjualan (id_laporan_keuangan, id_diskon, pajak, total_bayar, metode_pembayaran, tanggal_jual, catatan_penjualan, id_produk, jumlah_produk, harga_per_item) VALUES ('$id_laporan_keuangan', '$id_diskon', '$pajak', '$total_bayar', '$metode_pembayaran', '$tanggal_jual', '$catatan_penjualan', '$id_produk', '$jumlah_produk', '$harga_per_item')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $updateStockQuery = "UPDATE produk SET stok = stok - $jumlah_produk WHERE id_produk = '$id_produk'";
        mysqli_query($conn, $updateStockQuery);
    }

    return mysqli_affected_rows($conn);
}

// get by id
function getPenjualanById($id)
{
    global $conn;
    $query = "SELECT * FROM penjualan WHERE id_penjualan = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// get penjualan
// penjualan berelasi dengan diskon, produk dan laporan keuangan
// jika diskon null maka tampilkan datanya null saja

function getPenjualan()
{
    global $conn;
    $query = "SELECT penjualan.*, produk.nama_produk, produk.image, diskon.nama_diskon, diskon.persentase, diskon.batasan_harga, laporan_keuangan.id_laporan, laporan_keuangan.periode_mulai, laporan_keuangan.periode_selesai FROM penjualan LEFT JOIN produk ON penjualan.id_produk = produk.id_produk LEFT JOIN diskon ON penjualan.id_diskon = diskon.id_diskon LEFT JOIN laporan_keuangan ON penjualan.id_laporan_keuangan = laporan_keuangan.id_laporan";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
};

// deelte penjualan
function deletePenjualan($id)
{
    global $conn;
    $query = "DELETE FROM penjualan WHERE id_penjualan = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// search penjualan
function searchPenjualan($keyword)
{
    global $conn;
    $query = "SELECT penjualan.*, produk.nama_produk, produk.image, diskon.nama_diskon, diskon.persentase, diskon.batasan_harga, laporan_keuangan.id_laporan, laporan_keuangan.periode_mulai, laporan_keuangan.periode_selesai FROM penjualan LEFT JOIN produk ON penjualan.id_produk = produk.id_produk LEFT JOIN diskon ON penjualan.id_diskon = diskon.id_diskon LEFT JOIN laporan_keuangan ON penjualan.id_laporan_keuangan = laporan_keuangan.id_laporan WHERE produk.nama_produk LIKE '%$keyword%' OR penjualan.metode_pembayaran LIKE '%$keyword%' OR penjualan.tanggal_jual LIKE '%$keyword%' OR penjualan.catatan_penjualan LIKE '%$keyword%'";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

//update
function updatePenjualan($data)
{
    global $conn;
    $id = $data['id_penjualan'];
    $id_laporan_keuangan = $data['id_laporan_keuangan'];
    $id_diskon = $data['id_diskon'];
    $pajak = $data['pajak'];
    $total_bayar = $data['total_bayar'];
    $metode_pembayaran = $data['metode_pembayaran'];
    $tanggal_jual = $data['tanggal_jual'];
    $catatan_penjualan = $data['catatan_penjualan'];
    $id_produk = $data['id_produk'];
    $jumlah_produk = $data['jumlah_produk'];
    $harga_per_item = $data['harga_per_item'];
    $jumlah_produk_old = $data['jumlah_produk_old'];
    $id_produk_old = $data['id_produk_old'];
    $id_diskon_old = $data['id_diskon_old'];

    if ($id_produk == $id_produk_old) {
        $stockQuery = "SELECT stok FROM produk WHERE id_produk = '$id_produk'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $stockRow = mysqli_fetch_assoc($stockResult);
        $currentStock = $stockRow['stok'] + $jumlah_produk_old;

        if ($jumlah_produk > $currentStock) {
            echo "<script>
                alert('Jumlah produk yang dibeli melebihi stok yang tersedia.');
                window.location.href = '/penjualan/edit.php?id=$id';
            </script>";
            return 0;
        }

        // Update the sale record
        $query = "UPDATE penjualan SET 
            id_laporan_keuangan = '$id_laporan_keuangan', 
            id_diskon = '$id_diskon', 
            pajak = '$pajak', 
            total_bayar = '$total_bayar', 
            metode_pembayaran = '$metode_pembayaran', 
            tanggal_jual = '$tanggal_jual', 
            catatan_penjualan = '$catatan_penjualan', 
            id_produk = '$id_produk', 
            jumlah_produk = '$jumlah_produk', 
            harga_per_item = '$harga_per_item' 
            WHERE id_penjualan = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $stok = $currentStock - $jumlah_produk;
            $updateStockQuery = "UPDATE produk SET stok = $stok WHERE id_produk = '$id_produk'";
            $updateStockResult = mysqli_query($conn, $updateStockQuery);

            if ($updateStockResult) {
                return 1;
            } else {
                echo "<script>
                    alert('Gagal memperbarui stok produk.');
                    window.location.href = '/penjualan/edit.php?id=$id';
                </script>";
                return 0;
            }
        } else {
            echo "<script>
                alert('Gagal memperbarui data penjualan.');
                window.location.href = '/penjualan/edit.php?id=$id';
            </script>";
            return 0;
        }
    } else {
        $stockQuery = "SELECT stok FROM produk WHERE id_produk = '$id_produk'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $stockRow = mysqli_fetch_assoc($stockResult);
        $currentStock = $stockRow['stok'];

        if ($jumlah_produk > $currentStock) {
            echo "<script>
            alert('Jumlah produk yang dibeli melebihi stok yang tersedia.');
            window.location.href = '/penjualan/edit.php?id=$id';
        </script>";
            return 0;
        }

        $query = "UPDATE penjualan SET id_laporan_keuangan = '$id_laporan_keuangan', id_diskon = '$id_diskon', pajak = '$pajak', total_bayar = '$total_bayar', metode_pembayaran = '$metode_pembayaran', tanggal_jual = '$tanggal_jual', catatan_penjualan = '$catatan_penjualan', id_produk = '$id_produk', jumlah_produk = '$jumlah_produk', harga_per_item = '$harga_per_item' WHERE id_penjualan = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $updateStockQuery = "UPDATE produk SET stok = stok - $jumlah_produk WHERE id_produk = '$id_produk'";
            mysqli_query($conn, $updateStockQuery);
        }

        return mysqli_affected_rows($conn);
    }
}
