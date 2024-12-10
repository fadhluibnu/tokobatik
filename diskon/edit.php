<?php
$active = 'diskon';
include '../components/header.php';

include '../controller/diskon.php';
$id = $_GET['id'];
$diskon = getDiskonById($id);

if (isset($_POST['edit'])) {
    $data = [
        'id_diskon' => $_POST['id_diskon'],
        'nama_diskon' => $_POST['nama_diskon'],
        'periode_mulai' => $_POST['periode_mulai'],
        'periode_selesai' => $_POST['periode_selesai'],
        'persentase' => $_POST['persentase'],
        'batasan_diskon' => $_POST['batasan_diskon'],
        'minimal_pembelian' => $_POST['minimal_pembelian']
    ];
    $result = editDiskon($data);
    if ($result > 0) {
        echo "<script>
            alert('Diskon berhasil diubah!');
            window.location.href = '/diskon';
        </script>";
    } else {
        echo "<script>
            alert('Diskon gagal diubah!');
            window.location.href = '/diskon';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">

    <?php

    $titleMain = 'Edit Diskon';
    include '../components/header-main.php';

    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form class="space-y-4" id="tambah-produk-form" action="/diskon/edit.php?id=<?php echo $diskon['id_diskon']; ?>" method="post">
            <input type="hidden" name="id_diskon" value="<?php echo $diskon['id_diskon']; ?>">
            <div>
                <label for="nama_diskon" class="block text-sm font-medium text-gray-700">Nama Diskon</label>
                <input type="text" name="nama_diskon" id="nama_diskon" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="<?php echo $diskon['nama_diskon']; ?>" required>
            </div>
            <div>
                <label for="periode_mulai" class="block text-sm font-medium text-gray-700">Periode Mulai</label>
                <input type="date" name="periode_mulai" id="periode_mulai" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="<?php echo $diskon['periode_mulai']; ?>" required>
            </div>
            <div>
                <label for="periode_selesai" class="block text-sm font-medium text-gray-700">Periode Selesai</label>
                <input type="date" name="periode_selesai" id="periode_selesai" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="<?php echo $diskon['periode_selesai']; ?>" required>
            </div>
            <div>
                <label for="persentase" class="block text-sm font-medium text-gray-700">Persentase</label>
                <input type="number" name="persentase" id="persentase" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="<?php echo $diskon['persentase']; ?>" required>
            </div>
            <div>
                <label for="batasan_diskon" class="block text-sm font-medium text-gray-700">Batasan Diskon</label>
                <input type="number" name="batasan_diskon" id="batasan_diskon" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="<?php echo $diskon['batasan_diskon']; ?>" required>
            </div>
            <div>
                <label for="minimal_pembelian" class="block text-sm font-medium text-gray-700">Minimal Pembelian</label>
                <input type="number" name="minimal_pembelian" id="minimal_pembelian" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="<?php echo $diskon['minimal_pembelian']; ?>" required>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-md" name="edit">Edit Diskon</button>
            </div>
        </form>
    </section>

</div>