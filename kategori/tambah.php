<?php
$active = 'kategori';
include '../components/header.php';

if (isset($_POST['submitTambahKategori'])) {
    include '../controller/kategori.php';

    $data = [
        'nama_kategori' => $_POST['nama_kategori'],
        'deskripsi_produk' => $_POST['deskripsi_produk']
    ];

    $result = tambahKategori($data);

    if ($result > 0) {
        echo "<script>
            alert('Kategori berhasil ditambahkan!');
            window.location.href = '/kategori';
        </script>";
    } else {
        echo "<script>
            alert('Kategori gagal ditambahkan!');
            window.location.href = '/kategori';
        </script>";
    }
}

?>

<!-- Main Content -->
<div class="content w-full">

    <?php

    $titleMain = 'Tambah Produk';
    include '../components/header-main.php';

    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form class="space-y-4" id="tambah-produk-form" action="/kategori/tambah.php" method="post">
            <div>
                <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" class="form-input" required>
            </div>

            <div>
              <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Kategori</label>
              <textarea id="deskripsi_produk" name="deskripsi_produk" rows="4" class="form-input" required></textarea>
            </div>

            <!-- Button Simpan -->
            <div class="flex justify-end">
              <button type="submit" name="submitTambahKategori" class="btn-primary px-6 py-2 font-semibold">
                Simpan
              </button>
            </div>
        </form>
    </section>

</div>

<?php
include '../components/footer.php';
?>