<?php
$active = 'kategori';
include '../components/header.php';

$id = $_GET['id'];
include '../controller/kategori.php';
$dataKategori = getKategoriById($id);

if (isset($_POST['editTambahKategori'])){
    $data = [
        'id_kategori_produk' => $_POST['id_kategori_produk'],
        'nama_kategori' => $_POST['nama_kategori'],
        'deskripsi_produk' => $_POST['deskripsi_produk']
    ];

    $result = updateKategori($data);

    if ($result > 0) {
        echo "<script>
            alert('Kategori berhasil diubah!');
            window.location.href = '/kategori';
        </script>";
    } else {
        echo "<script>
            alert('Kategori gagal diubah!');
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
        <form class="space-y-4" id="tambah-produk-form" action="/kategori/edit.php?id=<?= $id ?>" method="post">
            <input type="hidden" name="id_kategori_produk" value="<?php echo $dataKategori['id_kategori_produk']; ?>">
            <div>
                <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" class="form-input" value="<?php echo htmlspecialchars($dataKategori['nama_kategori']); ?>" required>
            </div>

            <div>
              <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Kategori</label>
              <textarea id="deskripsi_produk" name="deskripsi_produk" rows="4" class="form-input" required><?php echo htmlspecialchars($dataKategori['deskripsi_produk']); ?></textarea>
            </div>

            <!-- Button Simpan -->
            <div class="flex justify-end">
              <button type="submit" name="editTambahKategori" class="btn-primary px-6 py-2 font-semibold">
                Simpan
              </button>
            </div>
        </form>
    </section>

</div>

<?php
include '../components/footer.php';
?>