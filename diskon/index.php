<?php
$active = 'diskon';
include '../components/header.php';

include '../controller/diskon.php';
$diskon = getDiskon();

if (isset($_POST['deleteDiskon'])) {
    $id = $_POST['id'];
    $result = deleteDiskon($id);
    if ($result > 0) {
        echo "<script>
            alert('Diskon berhasil dihapus!');
            window.location.href = '/diskon';
        </script>";
    } else {
        echo "<script>
            alert('Diskon gagal dihapus!');
            window.location.href = '/diskon';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Diskon';
    include '../components/header-main.php';

    ?>

    <?php

    $dataSearch = [
        'action' => '/diskon',
        'placeholder' => 'Cari diskon...',
        'btnText' => 'Cari',
        'btnTextTambah' => 'Tambah Diskon',
        'linkAdd' => '/diskon/tambah.php',
        'value' => isset($_GET['search']) ? $_GET['search'] : ''
    ];

    if (isset($_GET['submitSearch'])) {
        $keyword = $_GET['search'];
        $diskon = searchDiskon($keyword);
        if (count($diskon) == 0) {
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
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama Diskon</th>
                    <th class="px-4 py-2">Periode Mulai</th>
                    <th class="px-4 py-2">Periode Selesai</th>
                    <th class="px-4 py-2">Persentase</th>
                    <th class="px-4 py-2">Batasan Harga</th>
                    <th class="px-4 py-2">Minimal Pembelian</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <?php
                $no = 1;
                foreach ($diskon as $row) {
                ?>
                    <tr>
                        <td class="p-3"><?php echo $no++; ?></td>
                        <td class="p-3"><?php echo $row['nama_diskon']; ?></td>
                        <td class="p-3"><?php echo date('j F Y', strtotime($row['periode_mulai'])); ?></td>
                        <td class="p-3"><?php echo date('j F Y', strtotime($row['periode_selesai'])); ?></td>
                        <td class="p-3"><?php echo $row['persentase']; ?>%</td>
                        <td class="p-3">Rp. <?php echo number_format($row['batasan_harga'], 0, ',', '.'); ?></td>
                        <td class="p-3">Rp. <?php echo number_format($row['minimal_pembelian'], 0, ',', '.'); ?></td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <button class="bg-green-100 text-green-500 px-3 py-2 rounded-lg hover:bg-green-200" onclick="openDetail('<?= $row['id_diskon'] ?>')"><i class="fas fa-info-circle"></i></button>
                                <a href="/diskon/edit.php?id=<?php echo $row['id_diskon']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200" onclick="openDeleteModal('<?= $row['id_diskon'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>


                    <!-- Pop-up Modal for Delete -->
                    <div id="delete-modal<?= $row['id_diskon'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus diskon ini?</h3>
                            <div class="flex justify-end gap-4">
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('delete-modal<?= $row['id_diskon'] ?>')">Batal</button>
                                <form action="/diskon" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id_diskon']; ?>">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" type="submit" name="deleteDiskon">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        const discountData<?= $row['id_diskon'] ?> = [{
                            idDiskon: "<?= $row['id_diskon'] ?>",
                            namaDiskon: "<?= $row['nama_diskon'] ?>",
                            periodeMulai: "<?php echo date('j F Y', strtotime($row['periode_mulai'])); ?>",
                            periodeSelesai: "<?php echo date('j F Y', strtotime($row['periode_selesai'])); ?>",
                            persentase: <?php echo $row['persentase']; ?>,
                            minimalPembelian: <?php echo number_format($row['minimal_pembelian'], 0, ',', '.'); ?>,
                            batasHarga: <?php echo number_format($row['batasan_harga'], 0, ',', '.'); ?>
                        }, ];

                        localStorage.setItem("discountData<?= $row['id_diskon'] ?>", JSON.stringify(discountData<?= $row['id_diskon'] ?>));
                    </script>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>


    <!-- Pop-up Modal for Detail -->
    <div id="detail-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[600px]">
            <h3 class="text-xl font-semibold mb-4">Detail Diskon</h3>
            <div id="detail-content" class="mb-4"></div>
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('detail-modal')">Tutup</button>
        </div>
    </div>

    <script>
        function openDetail(idDiskon) {
            const discounts = JSON.parse(localStorage.getItem(`discountData${idDiskon}`));
            const diskon = discounts.find(d => d.idDiskon === idDiskon);
            if (diskon) {
                document.getElementById("detail-content").innerHTML = `
          <p><strong>ID Diskon:</strong> ${diskon.idDiskon}</p>
          <p><strong>Nama Diskon:</strong> ${diskon.namaDiskon}</p>
          <p><strong>Periode Mulai:</strong> ${diskon.periodeMulai}</p>
          <p><strong>Periode Selesai:</strong> ${diskon.periodeSelesai}</p>
          <p><strong>Persentase:</strong> ${diskon.persentase}%</p>
          <p><strong>Minimal Pembelian:</strong> Rp ${diskon.minimalPembelian.toLocaleString()}</p>
          <p><strong>Batas Harga:</strong> Rp ${diskon.batasHarga.toLocaleString()}</p>
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
<?php
include '../components/footer.php';
?>