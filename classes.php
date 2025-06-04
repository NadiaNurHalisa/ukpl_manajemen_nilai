<?php
require_once 'functions/auth.php';
require_once 'functions/classes.php';
checkAuth();

$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        createClass($_POST['name'], $_POST['description']);
    } elseif ($_POST['action'] === 'edit') {
        updateClass($_POST['id'], $_POST['name'], $_POST['description']);
    }
    header('Location: classes.php');
    exit;
}
if ($action === 'delete' && isset($_GET['id'])) {
    deleteClass($_GET['id']);
    header('Location: classes.php');
    exit;
}
$editClass = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $editClass = getClassById($_GET['id']);
}
$classes = getClasses();
?>
<?php include 'templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Manajemen Kelas</h1>
<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-4"><?= $editClass ? 'Edit Kelas' : 'Tambah Kelas' ?></h2>
    <form method="POST" class="space-y-4">
        <?php if ($editClass): ?>
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editClass['id'] ?>">
        <?php else: ?>
            <input type="hidden" name="action" value="add">
        <?php endif; ?>
        <div>
            <label class="block mb-1">Nama</label>
            <input type="text" name="name" value="<?= htmlspecialchars($editClass['name'] ?? '') ?>" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border px-3 py-2 rounded"><?= htmlspecialchars($editClass['description'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded"><?= $editClass ? 'Update' : 'Tambah' ?></button>
        <?php if ($editClass): ?>
            <a href="classes.php" class="ml-4 text-gray-600">Batal</a>
        <?php endif; ?>
    </form>
</div>
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Daftar Kelas</h2>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Deskripsi</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $cls): ?>
            <tr>
                <td class="border px-4 py-2"><?= $cls['id'] ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($cls['name']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($cls['description']) ?></td>
                <td class="border px-4 py-2 space-x-2">
                    <a href="classes.php?action=edit&id=<?= $cls['id'] ?>" class="text-blue-500">Edit</a>
                    <a href="classes.php?action=delete&id=<?= $cls['id'] ?>" class="text-red-500" onclick="return confirm('Yakin ingin hapus?');">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'templates/footer.php'; ?>
