<?php
$active = 'operasional';
include '../components/header.php';
include '../controller/BiayaOprasional.php';
$biayaOperasional = getBiayaOperasional();

if (isset($_POST['deleteBiayaOperasional'])) {
    $id = $_POST['id'];
    $result = deleteBiayaOperasional($id);
    if ($result > 0) {
        echo "<script>
            alert('Biaya operasional berhasil dihapus!');
            window.location.href = '/biaya-operasional';
        </script>";
    } else {
        echo "<script>
            alert('Biaya operasional gagal dihapus!');
            window.location.href = '/biaya-operasional';
        </script>";
    }
}
?>

<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Biaya Operasional';
    include '../components/header-main.php';

    ?>

    <?php

    $dataSearch = [
        'action' => '/biaya-operasional',
        'placeholder' => 'Cari biaya operasional...',
        'btnText' => 'Cari',
        'btnTextTambah' => 'Tambah Biaya Operasional',
        'linkAdd' => '/biaya-operasional/tambah.php',
        'value' => isset($_GET['search']) ? $_GET['search'] : ''
    ];

    if (isset($_GET['submitSearch'])) {
        $keyword = $_GET['search'];
        $biayaOperasional = searchBiayaOperasional($keyword);
        if (count($biayaOperasional) == 0) {
            echo "<script>
            alert('Data tidak ditemukan!');
            window.location.href = '/biaya-operasional';
        </script>";
        }
    }

    include '../components/search.php';

    ?>

    <!-- Penjualan Table -->
    <div class="bg-white rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Jenis Biaya</th>
                    <th class="p-3 text-left">Periode</th>
                    <th class="p-3 text-left">Total Biaya</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <!-- No, Jenis Biaya, Total Biaya, Deskripsi, Tanggal, Aksi (Edit, Delete) -->
                <?php
                $no = 1;
                foreach ($biayaOperasional as $biaya) : ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="p-3 text-left"><?= $no; ?></td>
                        <td class="p-3 text-left"><?= $biaya['jenis_biaya']; ?></td>
                        <td class="p-3 text-left"><?= date('j F Y', strtotime($biaya['periode_mulai'])) . ' - ' . date('j F Y', strtotime($biaya['periode_selesai'])); ?></td>
                        <td class="p-3 text-left"><?php echo (int)number_format($biaya['total_biaya'], 0, ',', '.'); ?></td>
                        <td class="p-3 text-left"><?= $biaya['deskripsi']; ?></td>
                        <td class="p-3 text-left"><?= date('j F Y', strtotime($biaya['tanggal'])); ?></td>
                        <td class="p-3 text-left">
                            <div class="flex gap-2">
                                <button class="bg-green-100 text-green-500 px-3 py-2 rounded-lg hover:bg-green-200" onclick="openDetail('<?= $biaya['id_biaya_opersional'] ?>')"><i class="fas fa-info-circle"></i></button>
                                <a href="/biaya-operasional/edit.php?id=<?php echo $biaya['id_biaya_opersional']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200" onclick="openDeleteModal('<?= $biaya['id_biaya_opersional'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Pop-up Modal for Delete -->
                    <div id="delete-modal<?= $biaya['id_biaya_opersional'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus diskon ini?</h3>
                            <div class="flex justify-end gap-4">
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('delete-modal<?= $biaya['id_biaya_opersional'] ?>')">Batal</button>
                                <form action="/biaya-operasional/" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $biaya['id_biaya_opersional']; ?>">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" type="submit" name="deleteBiayaOperasional">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>


                    <script>
                        const operasional<?= $biaya['id_biaya_opersional'] ?> = [{
                            id: '<?= $biaya['id_biaya_opersional'] ?>',
                            jenis_biaya: '<?= $biaya['jenis_biaya'] ?>',
                            periode: '<?= date('j F Y', strtotime($biaya['periode_mulai'])) . ' - ' . date('j F Y', strtotime($biaya['periode_selesai'])); ?>',
                            total_biaya: '<?= number_format((int)$biaya['total_biaya'], 0, ',', '.') ?>',
                            deskripsi: '<?= $biaya['deskripsi'] ?>',
                            tanggal: '<?= date('j F Y', strtotime($biaya['tanggal'])); ?>'
                        }, ];

                        localStorage.setItem("operasional<?= $biaya['id_biaya_opersional'] ?>", JSON.stringify(operasional<?= $biaya['id_biaya_opersional'] ?>));
                    </script>

                <?php
                    $no++;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pop-up Modal for Detail -->
    <div id="detail-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[600px]">
            <h3 class="text-xl font-semibold mb-4">Detail Biaya Operasional</h3>
            <div id="detail-content" class="mb-4"></div>
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('detail-modal')">Tutup</button>
        </div>
    </div>

    <script>
        function openDetail(id) {
            const operasionals = JSON.parse(localStorage.getItem(`operasional${id}`));
            const operasional = operasionals.find(d => d.id === id);
            if (operasional) {
                document.getElementById("detail-content").innerHTML = `
                    <p><span class="font-semibold">Jenis Biaya:</span> ${operasional.jenis_biaya}</p>
                    <p><span class="font-semibold">Periode:</span> ${operasional.periode}</p>
                    <p><span class="font-semibold">Total Biaya:</span> ${operasional.total_biaya}</p>
                    <p><span class="font-semibold">Deskripsi:</span> ${operasional.deskripsi}</p>
                    <p><span class="font-semibold">Tanggal:</span> ${operasional.tanggal}</p>
                `;
                document.getElementById("detail-modal").classList.remove("hidden");
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add("hidden");
        }

        function openDeleteModal(id) {
            document.getElementById(`delete-modal${id}`).classList.remove("hidden");
        }
    </script>

</div>