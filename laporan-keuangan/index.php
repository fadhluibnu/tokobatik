<?php
$active = 'keuangan';
include '../components/header.php';

include '../controller/LaporanKeuangan.php';
$dataLaporanKeuangan = getLaporanKeuangan();

if (isset($_POST['deleteLaporanKeuangan'])) {
    $id = $_POST['id'];
    $result = deleteLaporanKeuangan($id);
    if ($result > 0) {
        echo "<script>
            alert('Laporan keuangan berhasil dihapus!');
            window.location.href = '/laporan-keuangan';
        </script>";
    } else {
        echo "<script>
            alert('Laporan keuangan gagal dihapus!');
            window.location.href = '/laporan-keuangan';
        </script>";
    }
}
?>

<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Laporan Keuangan';
    include '../components/header-main.php';

    ?>

    <?php

    $dataSearch = [
        'action' => '/laporan-keuangan',
        'placeholder' => 'Cari keuangan...',
        'btnText' => 'Cari',
        'btnTextTambah' => 'Tambah Laporan Keuangan',
        'linkAdd' => '/laporan-keuangan/tambah.php',
        'value' => isset($_GET['search']) ? $_GET['search'] : ''
    ];

    if (isset($_GET['submitSearch'])) {
        $keyword = $_GET['search'];
        $dataLaporanKeuangan = searchLaporanKeuangan($keyword);
        if (count($dataLaporanKeuangan) == 0) {
            echo "<script>
            alert('Data tidak ditemukan!');
            window.location.href = '/laporan-keuangan';
        </script>";
        }
    }

    include '../components/search.php';

    ?>

    <div class="bg-white rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left">Periode Mulai</th>
                    <th class="p-3 text-left">Periode Selesai</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($dataLaporanKeuangan as $laporanKeuangan) {
                ?>
                    <tr>
                        <td class="p-3"><?php echo $no++; ?></td>
                        <td class="p-3"><?php echo $laporanKeuangan['deskripsi']; ?></td>
                        <td class="p-3"><?php echo date('j F Y', strtotime($laporanKeuangan['periode_mulai'])); ?></td>
                        <td class="p-3"><?php echo date('j F Y', strtotime($laporanKeuangan['periode_selesai'])); ?></td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="/laporan-keuangan/detail.php?id=<?= $laporanKeuangan['id_laporan'] ?>" class="bg-green-100 text-green-500 px-3 py-2 rounded-lg hover:bg-green-200"><i class="fas fa-info-circle"></i></a>
                                <a href="/laporan-keuangan/edit.php?id=<?php echo $laporanKeuangan['id_laporan']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200" onclick="openDeleteModal('<?= $laporanKeuangan['id_laporan'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Pop-up Modal for Delete -->
                    <div id="delete-modal<?= $laporanKeuangan['id_laporan']; ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus laporan keuangan ini?</h3>
                            <div class="flex justify-end gap-4">
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('delete-modal<?= $laporanKeuangan['id_laporan'] ?>')">Batal</button>
                                <form action="/laporan-keuangan/" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $laporanKeuangan['id_laporan']; ?>">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" type="submit" name="deleteLaporanKeuangan">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
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