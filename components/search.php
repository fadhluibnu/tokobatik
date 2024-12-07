<!-- Search and Add Product -->
<div class="flex justify-between">
    <form class="flex items-center mb-4 w-full gap-4" action="<?= $dataSearch['action'] ?>">
        <input type="text" placeholder="<?= $dataSearch['placeholder'] ?>" class="border border-gray-300 rounded-lg p-2 w-1/2" name="search" value="<?= $dataSearch['value'] ?>" />
        <button type="submit" name="submitSearch" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 active:bg-blue-700"><?= $dataSearch['btnText'] ?></button>
    </form>
    <a href="<?= $dataSearch['linkAdd'] ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 active:bg-blue-700"><?= $dataSearch['btnTextTambah'] ?></a>
</div>