<?php
$active = 'pembelian';
include '../components/header.php';

include '../controller/pembelian.php';
$pembelian = getPembelian();

if (isset($_POST['deletePembelian'])) {
    $id = $_POST['id'];
    $result = deletePembelian($id);

    if ($result > 0) {
        echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = '/pembelian';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus!');
            window.location.href = '/pembelian';
        </script>";
    }
}
?>

<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Pembelian';
    include '../components/header-main.php';

    ?>

    <?php

    $dataSearch = [
        'action' => '/pembelian',
        'placeholder' => 'Cari pembelian...',
        'btnText' => 'Cari',
        'btnTextTambah' => 'Tambah Pembelian',
        'linkAdd' => '/pembelian/tambah.php',
        'value' => isset($_GET['search']) ? $_GET['search'] : ''
    ];

    if (isset($_GET['submitSearch'])) {
        $keyword = $_GET['search'];
        $pembelian = searchPembelian($keyword);
        if (count($pembelian) == 0) {
            echo "<script>
            alert('Data tidak ditemukan!');
            window.location.href = '/pembelian';
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
                    <th class="p-3 text-left">Nama Barang</th>
                    <th class="p-3 text-left">Harga per Barang</th>
                    <th class="p-3 text-left">Jumlah Barang</th>
                    <th class="p-3 text-left">Status Pembelian</th>
                    <th class="p-3 text-left">Total Pembelian</th>
                    <th class="p-3 text-left">Tanggal Beli</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <?php $no = 1; ?>
                <?php foreach ($pembelian as $p): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="p-3"><?php echo $no++; ?></td>
                        <td class="p-3"><?php echo $p['nama_barang']; ?></td>
                        <td class="p-3"><?php echo (int)$p['harga_perbarang']; ?></td>
                        <td class="p-3"><?php echo $p['jumlah_barang']; ?></td>
                        <td class="p-3"><?php echo $p['status_pembelian']; ?></td>
                        <td class="p-3"><?php echo (int)$p['total_pembelian']; ?></td>
                        <td class="p-3"><?php echo $p['tanggal_beli']; ?></td>
                        <td class="p-3 text-left">
                            <div class="flex gap-2">
                                <button class="bg-green-100 text-green-500 px-3 py-2 rounded-lg hover:bg-green-200" onclick="openDetail('<?= $p['id_pembelian'] ?>')"><i class="fas fa-info-circle"></i></button>
                                <a href="/pembelian/edit.php?id=<?php echo $p['id_pembelian']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200" onclick="openDeleteModal('<?= $p['id_pembelian'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Pop-up Modal for Delete -->
                    <div id="delete-modal<?= $p['id_pembelian'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus diskon ini?</h3>
                            <div class="flex justify-end gap-4">
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('delete-modal<?= $p['id_pembelian'] ?>')">Batal</button>
                                <form action="/pembelian/" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $p['id_pembelian']; ?>">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" type="submit" name="deletePembelian">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        const pembelian<?= $p['id_pembelian'] ?> = [{
                            id_pembelian: <?= $p['id_pembelian'] ?>,
                            total_pembelian: <?= (int)$p['total_pembelian'] ?>,
                            metode_pembayaran: '<?= $p['metode_pembayaran'] ?>',
                            status_pembelian: '<?= $p['status_pembelian'] ?>',
                            status_pembayaran: '<?= $p['status_pembayaran'] ?>',
                            tanggal_beli: '<?= date('j F Y', strtotime($p['tanggal_beli'])) ?>',
                            catatan_pembelian: '<?= $p['catatan_pembelian'] ?>',
                            harga_perbarang: <?= (int)$p['harga_perbarang'] ?>,
                            nama_barang: '<?= $p['nama_barang'] ?>',
                            jumlah_barang: <?= (int)$p['jumlah_barang'] ?>,
                            periode_mulai: '<?= date('j F Y', strtotime($p['periode_mulai'])) ?>',
                            periode_selesai: '<?= date('j F Y', strtotime($p['periode_selesai'])) ?>',
                        }, ];
                        localStorage.removeItem("pembelian<?= $p['id_pembelian'] ?>");
                        localStorage.setItem("pembelian<?= $p['id_pembelian'] ?>", JSON.stringify(pembelian<?= $p['id_pembelian'] ?>));
                    </script>

                <?php endforeach; ?>
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
</div>


<script>
    function openDetail(idPembelian) {
        const pembelians = JSON.parse(localStorage.getItem(`pembelian${idPembelian}`));
        const pembelian = pembelians.find(d => d.id_pembelian == idPembelian);
        console.log(pembelians);
        console.log(idPembelian);
        if (pembelian) {
            document.getElementById("detail-content").innerHTML = `
                <p><span class="font-semibold">Nama Barang:</span> ${pembelian.nama_barang}</p>
                <p><span class="font-semibold">Harga per Barang:</span> ${pembelian.harga_perbarang}</p>
                <p><span class="font-semibold">Jumlah Barang:</span> ${pembelian.jumlah_barang}</p>
                <p><span class="font-semibold">Status Pembelian:</span> ${pembelian.status_pembelian}</p>
                <p><span class="font-semibold">Total Pembelian:</span> ${pembelian.total_pembelian}</p>
                <p><span class="font-semibold">Tanggal Beli:</span> ${pembelian.tanggal_beli}</p>
                <p><span class="font-semibold">Metode Pembayaran:</span> ${pembelian.metode_pembayaran}</p>
                <p><span class="font-semibold">Status Pembayaran:</span> ${pembelian.status_pembayaran}</p>
                <p><span class="font-semibold">Catatan Pembelian:</span> ${pembelian.catatan_pembelian}</p>
                <hr>
                <p><span class="font-semibold"><b>Periode Laporan Keuangan :</b></p>
                <p><span class="font-semibold">Periode Mulai:</span> ${pembelian.periode_mulai}</p>
                <p><span class="font-semibold">Periode Selesai:</span> ${pembelian.periode_selesai}</p>
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