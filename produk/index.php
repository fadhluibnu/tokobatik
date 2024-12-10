<?php
$active = 'produk';
include '../components/header.php';
include '../controller/produk.php';

$dataProduk = getProduk();

if (isset($_POST['deleteProduk'])) {
    $id = $_POST['id'];
    $result = deleteProduk($id);
    if ($result > 0) {
        echo "<script>
            alert('Produk berhasil dihapus!');
            window.location.href = '/produk';
        </script>";
    } else {
        echo "<script>
            alert('Produk gagal dihapus!');
            window.location.href = '/produk';
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content w-full">

    <?php

    $titleMain = 'Manajemen Produk';
    include '../components/header-main.php';

    ?>

    <?php

    $dataSearch = [
        'action' => '/produk',
        'placeholder' => 'Cari produk...',
        'btnText' => 'Cari',
        'btnTextTambah' => 'Tambah Produk',
        'linkAdd' => '/produk/tambah.php',
        'value' => isset($_GET['search']) ? $_GET['search'] : ''
    ];

    if (isset($_GET['submitSearch'])) {
        $keyword = $_GET['search'];
        $dataProduk = searchProduk($keyword);
        if (count($dataProduk) == 0) {
            echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href = '/produk';
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
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Kode Produk</th>
                    <th class="p-3 text-left">Image</th>
                    <th class="p-3 text-left">Nama Produk</th>
                    <th class="p-3 text-left">Kategori</th>
                    <th class="p-3 text-left">Stok</th>
                    <th class="p-3 text-left">Harga Satuan</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($dataProduk as $produk) { ?>
                    <tr>
                        <td class="p-3"><?php echo $no++; ?></td>
                        <td class="p-3"><?php echo $produk['kode_produk']; ?></td>
                        <td class="p-3"><img src="<?php echo $produk['image']; ?>" alt="<?php echo $produk['nama_produk']; ?>" width="50"></td>
                        <td class="p-3"><?php echo $produk['nama_produk']; ?></td>
                        <td class="p-3"><?php echo $produk['nama_kategori']; ?></td>
                        <td class="p-3"><?php echo $produk['stok']; ?></td>
                        <td class="p-3">Rp. <?php echo number_format((int)$produk['harga_satuan'], 0, ',', '.'); ?></td>
                        <td class="p-3"><?php echo $produk['status_aktif']; ?></td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <button class="bg-green-100 text-green-500 px-3 py-2 rounded-lg hover:bg-green-200" onclick="openDetail('<?= $produk['id_produk'] ?>')"><i class="fas fa-info-circle"></i></button>
                                <a href="/produk/edit.php?id=<?php echo $produk['id_produk']; ?>" class="bg-blue-100 text-blue-500 px-3 py-2 rounded-lg hover:bg-blue-200 shadow-md" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-3 py-2 rounded-lg hover:bg-red-200" onclick="openDeleteModal('<?= $produk['id_produk'] ?>')"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Pop-up Modal for Delete -->
                    <div id="delete-modal<?= $produk['id_produk'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus diskon ini?</h3>
                            <div class="flex justify-end gap-4">
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('delete-modal<?= $produk['id_produk'] ?>')">Batal</button>
                                <form action="/produk" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $produk['id_produk']; ?>">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" type="submit" name="deleteProduk">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        const produkData<?= $produk['id_produk'] ?> = [{
                            id_produk: <?= $produk['id_produk'] ?>,
                            kode_produk: "<?= $produk['kode_produk'] ?>",
                            nama_produk: "<?= $produk['nama_produk'] ?>",
                            nama_kategori: "<?= $produk['nama_kategori'] ?>",
                            stok: <?= $produk['stok'] ?>,
                            harga_satuan: <?= number_format($produk['harga_satuan'], 0, ',', '.') ?>,
                            status_aktif: "<?= $produk['status_aktif'] ?>",
                            image: "<?= $produk['image'] ?>",
                            deskripsi: "<?= $produk['deskripsi_produk'] ?>",
                            dimensi_produk: "<?= $produk['dimensi_produk'] ?>",
                            berat_produk: "<?= $produk['berat_produk'] ?>",
                        }, ];

                        localStorage.setItem("produkData<?= $produk['id_produk'] ?>", JSON.stringify(produkData<?= $produk['id_produk'] ?>));
                    </script>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pop-up Modal for Detail -->
    <div id="detail-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[600px]">
            <h3 class="text-xl font-semibold mb-4">Detail Produk</h3>
            <div id="detail-content" class="mb-4"></div>
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('detail-modal')">Tutup</button>
        </div>
    </div>

    <script>
        function openDetail(id_produk) {
            const produks = JSON.parse(localStorage.getItem(`produkData${id_produk}`));
            const produk = produks.find(d => d.id_produk == id_produk);
            if (produk) {
                document.getElementById("detail-content").innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <img src="${produk.image}" alt="${produk.nama_produk}" class="w-full h-auto">
                        </div>
                        <div>
                            <p><span class="font-semibold">Kode Produk:</span> ${produk.kode_produk}</p>
                            <p><span class="font-semibold">Nama Produk:</span> ${produk.nama_produk}</p>
                            <p><span class="font-semibold">Kategori:</span> ${produk.nama_kategori}</p>
                            <p><span class="font-semibold">Stok:</span> ${produk.stok}</p>
                            <p><span class="font-semibold">Harga Satuan:</span> Rp. ${produk.harga_satuan.toLocaleString()}</p>
                            <p><span class="font-semibold">Status:</span> ${produk.status_aktif}</p>
                            <p><span class="font-semibold">Dimensi Produk:</span> ${produk.dimensi_produk.toLocaleString()}</p>
                            <p><span class="font-semibold">Berat Produk:</span> ${produk.berat_produk.toLocaleString()}</p>
                            <p><span class="font-semibold">Deskripsi:</span> ${produk.deskripsi}</p>
                        </div>
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


<?php
include '../components/footer.php';
?>