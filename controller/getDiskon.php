<?php
// include 'koneksi.php';

// function getAvailableDiscounts()
// {
//     global $conn;
//     $currentDate = date('Y-m-d');
//     $query = "SELECT * FROM diskon WHERE periode_mulai <= '$currentDate' AND periode_selesai >= '$currentDate'";
//     $result = mysqli_query($conn, $query);
//     $discounts = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//         $discounts[] = $row;
//     }
//     return $discounts;
// }

// $discounts = getAvailableDiscounts();
// echo json_encode($discounts);


include 'koneksi.php';
if (isset($_GET['date']) && isset($_GET['total'])) {
    $currentDate = $_GET['date'];
    $totalPurchase = (float)$_GET['total'];
    $discounts = getAvailableDiscounts($currentDate, $totalPurchase);
    echo json_encode($discounts);
}

function getAvailableDiscounts($currentDate, $totalPurchase) {
    global $conn;
    $query = "SELECT * FROM diskon WHERE periode_mulai <= '$currentDate' AND periode_selesai >= '$currentDate' AND minimal_pembelian <= $totalPurchase";
    $result = mysqli_query($conn, $query);
    $discounts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $discounts[] = $row;
    }
    return $discounts;
}