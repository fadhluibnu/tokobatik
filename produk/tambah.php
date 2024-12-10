<?php
$active = 'produk';
include '../components/header.php';

if (isset($_POST['simpanProduk'])) {
    include '../controller/produk.php';

    $target_dir = "../uploads/";
    $target_file = $target_dir . rand() . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>
            alert('File is not an image.');
            window.location.href = '/produk/tambah.php';
        </script>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<script>
            alert('Sorry, file already exists.');
            window.location.href = '/produk/tambah.php';
        </script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) {
        echo "<script>
            alert('Sorry, your file is too large.');
            window.location.href = '/produk/tambah.php';
        </script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "<script>
            alert('Sorry, only JPG, JPEG, & PNG files are allowed.');
            window.location.href = '/produk/tambah.php';
        </script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>
            alert('Sorry, your file was not uploaded.');
            window.location.href = '/produk/tambah.php';
        </script>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $data  = [
                'nama_produk' => $_POST['nama_produk'],
                'kode_produk' => $_POST['kode_produk'],
                'deskripsi_produk' => $_POST['deskripsi_produk'],
                'berat_produk' => $_POST['berat_produk'],
                'harga_satuan' => $_POST['harga_satuan'],
                'stok' => $_POST['stok'],
                'id_kategori_produk' => $_POST['id_kategori_produk'],
                'lokasi_penyimpanan' => $_POST['lokasi_penyimpanan'],
                'status_aktif' => $_POST['status_aktif'],
                'dimensi_produk' => $_POST['dimensi_produk'],
                'image' => $target_file
            ];
            $result = tambahProduk($data);
            if ($result > 0) {
                echo "<script>
                    alert('Produk berhasil ditambahkan');
                    window.location.href = '/produk';
                </script>";
            } else {
                echo "<script>
                    alert('Produk gagal ditambahkan');
                    window.location.href = '/produk/tambah.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Sorry, there was an error uploading your file.');
                window.location.href = '/produk/tambah.php';
            </script>";
        }
    }
}

?>

<!-- Main Content -->
<div class="content w-full">
    <?php

    $titleMain = 'Manajemen Produk';
    include '../components/header-main.php';

    ?>

    <section class="bg-white p-6 rounded shadow-md">
        <form class="space-y-4" id="tambah-produk-form" action="/produk/tambah.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                <input type="file" id="image" name="image" class="form-input" accept="image/*" onchange="previewImage(event)" required>
                <img id="image-preview" src="#" alt="Preview Gambar" class="mt-2 hidden w-32 h-32 object-cover">
            </div>

            <script>
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function(){
                    var output = document.getElementById('image-preview');
                    output.src = reader.result;
                    output.classList.remove('hidden');
                };
                reader.readAsDataURL(event.target.files[0]);
            }
            </script>
            <div>
                <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" class="form-input" required>
            </div>
            <div>
                <label for="kode_produk" class="block text-sm font-medium text-gray-700">Kode Produk</label>
                <input type="text" id="kode_produk" name="kode_produk" class="form-input" required>
            </div>
            <div>
                <label for="deskripsi_produk" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                <textarea id="deskripsi_produk" name="deskripsi_produk" rows="4" class="form-input" required></textarea>
            </div>
            <div>
                <label for="berat_produk" class="block text-sm font-medium text-gray-700">Berat Produk</label>
                <input type="text" id="berat_produk" name="berat_produk" class="form-input" required>
            </div>
            <div>
                <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga Satuan</label>
                <input type="number" id="harga_satuan" name="harga_satuan" class="form-input" required>
            </div>
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" id="stok" name="stok" class="form-input" required>
            </div>
            <?php
            include '../controller/kategori.php';

            $kategori = getKategori();
            ?>
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="kategori" name="id_kategori_produk" class="form-select border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori as $item) : ?>
                        <option value="<?= $item['id_kategori_produk'] ?>"><?= $item['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="lokasi_penyimpanan" class="block text-sm font-medium text-gray-700">Lokasi Penyimpanan</label>
                <input type="text" id="lokasi_penyimpanan" name="lokasi_penyimpanan" class="form-input" required>
            </div>
            <div>
                <label for="status_aktif" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                <select id="status_aktif" name="status_aktif" class="form-select border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
            <div>
                <label for="dimensi_produk" class="block text-sm font-medium text-gray-700">Dimensi Produk</label>
                <input type="text" id="dimensi_produk" name="dimensi_produk" class="form-input" required>
            </div>

            <!-- Button Simpan -->
            <div class="flex justify-end">
                <button type="submit" class="btn-primary px-6 py-2 font-semibold" name="simpanProduk">
                    Simpan
                </button>
            </div>
        </form>
    </section>
</div>