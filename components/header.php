<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk - Sistem Manajemen Toko</title>
  <link href="../assets/styles.css" rel="stylesheet">
  <script src="../assets/tailwind.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800">

  <!-- Wrapper -->
  <div class="flex h-screen flex-col items-center">

    <!-- Header -->
    <header class="header w-full">
      <h1 class="text-3xl font-bold text-gray-800">Sistem Manajemen Toko</h1>
    </header>

    <!-- Content Wrapper -->
    <div class="flex w-full">

      <!-- Sidebar -->
      <aside class="sidebar">
        <nav>
          <ul class="menu">
            <li><a href="/" class="<?php echo $active == 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="/produk" class="<?php echo $active == 'produk' ? 'active' : ''; ?>">Produk</a></li>
            <li><a href="/kategori" class="<?php echo ($active == 'kategori') ? 'active' : '' ; ?>">Kategori</a></li>
            <li><a href="/penjualan" class="<?php echo $active == 'penjualan' ? 'active' : ''; ?>">Penjualan</a></li>
            <li><a href="/diskon" class="<?php echo $active == 'diskon' ? 'active' : ''; ?>">Diskon</a></li>
            <li><a href="/pembelian" class="<?php echo $active == 'pembelian' ? 'active' : ''; ?>">Pembelian</a></li>
            <li><a href="/biaya-operasional" class="<?php echo $active == 'operasional' ? 'active' : '' ?>" >Biaya Operasional</a></li>
            <li><a href="/laporan-keuangan" class="<?php echo $active == 'keuangan' ? 'active' : '' ?>">Laporan Keuangan</a></li>
          </ul>
        </nav>
      </aside>