<?php
$active = 'kategori';
include '../components/header.php';

if (isset($_POST['deleteKategori'])) {
    $id = $_POST['id'];
    include '../controller/kategori.php';
    $result = deleteKategori($id);
    if ($result > 0) {
        echo "<script>
            alert('Kategori berhasil dihapus!');
            window.location.href = '/kategori';
        </script>";
    } else {
        echo "<script>
            alert('Kategori gagal dihapus!');
            window.location.href = '/kategori';
        </script>";
    }
}

include '../controller/kategori.php';

$dataKategori = getKategori();

?>

<!-- Main Content -->
<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Kategori Produk';
    include '../components/header-main.php';

    ?>

    <?php

    $dataSearch = [
        'action' => '/kategori',
        'placeholder' => 'Cari kategori...',
        'btnText' => 'Cari',
        'btnTextTambah' => 'Tambah Kategori',
        'linkAdd' => '/kategori/tambah.php',
        'value' => isset($_GET['search']) ? $_GET['search'] : ''
    ];

    if (isset($_GET['submitSearch'])) {
        $keyword = $_GET['search'];
        $dataKategori = searchKategori($keyword);
        if (count($dataKategori) == 0) {
            echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href = '/kategori';
            </script>";
        }
    }

    include '../components/search.php';

    ?>

    <!-- Kategori Table -->
    <div class="bg-white rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">No.</th>
                    <th class="p-3 text-left">Nama Kategori</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left">Tanggal Dibuat</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <?php foreach ($dataKategori as $index => $kategori): ?>
                    <tr>
                        <td class="p-3"><?php echo $index + 1; ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($kategori['nama_kategori']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($kategori['deskripsi_produk']); ?></td>
                        <td class="p-3"><?php echo date('d F Y', strtotime($kategori['tanggal_dibuat'])); ?></td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="/kategori/edit.php?id=<?php echo $kategori['id_kategori_produk']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200" onclick="openDeleteModal('<?= $kategori['id_kategori_produk'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Pop-up Modal for Delete -->
                    <div id="delete-modal<?= $kategori['id_kategori_produk'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus diskon ini?</h3>
                            <div class="flex justify-end gap-4">
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('delete-modal<?= $p['id_pembelian'] ?>')">Batal</button>
                                <form action="/kategori" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $kategori['id_kategori_produk']; ?>">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" type="submit" name="deleteKategori">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add("hidden");
    }

    function openDeleteModal(id) {
        document.getElementById(`delete-modal${id}`).classList.remove("hidden");
    }
</script>

<?php
include '../components/footer.php';
?>