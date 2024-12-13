<?php
$active = 'penjualan';
include '../components/header.php';

include '../controller/penjualan.php';
$penjualans = getPenjualan();

if (isset($_POST['deletePenjualan'])) {
    $id = $_POST['id'];
    $result = deletePenjualan($id);
    if ($result > 0) {
        echo "<script>
            alert('Data penjualan berhasil dihapus!');
            window.location.href = '/penjualan';
        </script>";
    } else {
        echo "<script>
            alert('Data penjualan gagal dihapus!');
            window.location.href = '/penjualan';
        </script>";
    }
}
?>

<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Penjualan';
    include '../components/header-main.php';

    ?>

    <?php

    $dataSearch = [
        'action' => '/penjualan',
        'placeholder' => 'Cari penjualan...',
        'btnText' => 'Cari',
        'btnTextTambah' => 'Tambah Penjualan',
        'linkAdd' => '/penjualan/tambah.php',
        'value' => isset($_GET['search']) ? $_GET['search'] : ''
    ];

    if (isset($_GET['submitSearch'])) {
        $keyword = $_GET['search'];
        $penjualans = searchPenjualan($keyword);
        if (count($penjualans) == 0) {
            echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href = '/penjualan';
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
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Gambar Produk</th>
                    <th class="p-3 text-left">Nama Produk</th>
                    <th class="p-3 text-left">Jumlah Produk</th>
                    <th class="p-3 text-left">Total Harga</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <?php
                $no = 1;
                foreach ($penjualans as $penjualan) : ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="p-3 text-left"><?php echo $no++; ?></td>
                        <td class="p-3 text-left">
                            <img src="<?= $penjualan['image'] ?>" alt="<?= $penjualan['nama_produk'] ?>" class="w-20 h-20 object-cover">
                        </td>
                        <td class="p-3 text-left"><?= $penjualan['nama_produk'] ?></td>
                        <td class="p-3 text-left"><?= $penjualan['jumlah_produk'] ?></td>
                        <td class="p-3 text-left">Rp. <?= number_format((int)$penjualan['total_bayar'], 0, ',', '.') ?></td>
                        <td class="p-3 text-left"><?= date('j F Y', strtotime($penjualan['tanggal_jual'])) ?></td>
                        <td class="p-3 text-left">
                            <div class="flex gap-2">
                                <button class="bg-green-100 text-green-500 px-3 py-2 rounded-lg hover:bg-green-200" onclick="openDetail('<?= $penjualan['id_penjualan'] ?>')"><i class="fas fa-info-circle"></i></button>
                                <a href="/penjualan/edit.php?id=<?php echo $penjualan['id_penjualan']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200" onclick="openDeleteModal('<?= $penjualan['id_penjualan'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Pop-up Modal for Delete -->
                    <div id="delete-modal<?= $penjualan['id_penjualan'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus penjualan ini?</h3>
                            <div class="flex justify-end gap-4">
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('delete-modal<?= $penjualan['id_penjualan'] ?>')">Batal</button>
                                <form action="/penjualan" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $penjualan['id_penjualan']; ?>">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" type="submit" name="deletePenjualan">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        const penjualans<?= $penjualan['id_penjualan'] ?> = [{
                            "id_penjualan": "<?= $penjualan['id_penjualan'] ?>",
                            "total_bayar": "<?= number_format((int)$penjualan['total_bayar'], 0, ',', '.') ?>",
                            "metode_pembayaran": "<?= $penjualan['metode_pembayaran'] ?>",
                            "tanggal_jual": "<?= $penjualan['tanggal_jual'] ?>",
                            "catatan_penjualan": "<?= $penjualan['catatan_penjualan'] ?>",
                            "id_produk": "<?= $penjualan['id_produk'] ?>",
                            "jumlah_produk": "<?= $penjualan['jumlah_produk'] ?>",
                            "harga_per_item": "<?= number_format((int)$penjualan['harga_per_item'], 0, ',', '.') ?>",
                            "periode_mulai": "<?= $penjualan['periode_mulai'] ?>",
                            "periode_selesai": "<?= $penjualan['periode_selesai'] ?>",
                            "diskon": "<?= $penjualan['persentase'] ?>",
                            "nama_produk": "<?= $penjualan['nama_produk'] ?>",
                            "image": "<?= $penjualan['image'] ?>",
                            "max_diskon": "<?= number_format((int)$penjualan['batasan_harga'], 0, ',', '.') ?>"
                        }, ];

                        localStorage.setItem("penjualans<?= $penjualan['id_penjualan'] ?>", JSON.stringify(penjualans<?= $penjualan['id_penjualan'] ?>));
                    </script>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pop-up Modal for Detail -->
    <div id="detail-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[600px]">
            <h3 class="text-xl font-semibold mb-4">Detail Penjualan</h3>
            <div id="detail-content" class="mb-4"></div>
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('detail-modal')">Tutup</button>
        </div>
    </div>
    <script>
        function openDetail(id_penjualan) {
            const penjualans = JSON.parse(localStorage.getItem(`penjualans${id_penjualan}`));
            const penjualan = penjualans.find(d => d.id_penjualan === id_penjualan);
            if (penjualan) {
                document.getElementById("detail-content").innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <img src="${penjualan.image}" alt="${penjualan.nama_produk}" class="w-full h-auto">
                        </div>
                        <div>
                            <p><span class="font-semibold">Nama Produk:</span> ${penjualan.nama_produk}</p>
                            <p><span class="font-semibold">Total Bayar:</span> Rp. ${penjualan.total_bayar}</p>
                            <p><span class="font-semibold">Metode Pembayaran:</span> ${penjualan.metode_pembayaran}</p>
                            <p><span class="font-semibold">Tanggal Jual:</span> ${penjualan.tanggal_jual}</p>
                            <p><span class="font-semibold">Catatan Penjualan:</span> ${penjualan.catatan_penjualan}</p>
                            <p><span class="font-semibold">ID Produk:</span> ${penjualan.id_produk}</p>
                            <p><span class="font-semibold">Jumlah Produk:</span> ${penjualan.jumlah_produk}</p>
                            <p><span class="font-semibold">Harga Per Item:</span> Rp. ${penjualan.harga_per_item}</p>
                            <p><span class="font-semibold">Periode Mulai:</span> ${penjualan.periode_mulai}</p>
                            <p><span class="font-semibold">Periode Selesai:</span> ${penjualan.periode_selesai}</p>
                            <p><span class="font-semibold">Diskon:</span> ${penjualan.diskon}%</p>
                            <p><span class="font-semibold">Max Diskon:</span> Rp. ${penjualan.max_diskon.toLocaleString()}</p>
                    </div>
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