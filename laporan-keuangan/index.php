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
                                <a href="/laporan-keuangan/edit.php?id=<?php echo $laporanKeuangan['id_laporan']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="/laporan-keuangan" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan keuangan ini?');">
                                    <input type="hidden" name="id" value="<?php echo $laporanKeuangan['id_laporan']; ?>">
                                    <button class="delete-button bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200 shadow-md" type="submit" name="deleteLaporanKeuangan">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>