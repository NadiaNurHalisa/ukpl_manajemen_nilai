<?php
require_once 'functions/auth.php';
require_once 'functions/grades.php';
require_once 'functions/students.php';
checkAuth();

$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        createGrade($_POST['student_id'], $_POST['subject'], $_POST['score']);
    } elseif ($_POST['action'] === 'edit') {
        updateGrade($_POST['id'], $_POST['subject'], $_POST['score']);
    }
    header('Location: grades.php');
    exit;
}
if ($action === 'delete' && isset($_GET['id'])) {
    deleteGrade($_GET['id']);
    header('Location: grades.php');
    exit;
}
$editGrade = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $editGrade = getGradeById($_GET['id']);
}
$grades = getGrades();
$students = getStudents();
?>
<?php include 'templates/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Input/Edit Nilai</h1>
<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-4"><?= $editGrade ? 'Edit Nilai' : 'Tambah Nilai' ?></h2>
    <form method="POST" class="space-y-4">
        <?php if ($editGrade): ?>
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editGrade['id'] ?>">
        <?php else: ?>
            <input type="hidden" name="action" value="add">
        <?php endif; ?>
        <div>
            <label class="block mb-1">Siswa</label>
            <select name="student_id" class="w-full border px-3 py-2 rounded" required>
                <?php foreach ($students as $std): ?>
                    <option value="<?= $std['id'] ?>" <?= ($editGrade && $editGrade['student_id'] == $std['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($std['full_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Mata Pelajaran</label>
            <input type="text" name="subject" value="<?= htmlspecialchars($editGrade['subject'] ?? '') ?>" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Skor</label>
            <input type="number" name="score" min="0" max="100" value="<?= htmlspecialchars($editGrade['score'] ?? '') ?>" class="w-full border px-3 py-2 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded"><?= $editGrade ? 'Update' : 'Tambah' ?></button>
        <?php if ($editGrade): ?>
            <a href="grades.php" class="ml-4 text-gray-600">Batal</a>
        <?php endif; ?>
    </form>
</div>
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Daftar Nilai</h2>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nama Siswa</th>
                <th class="px-4 py-2">Mata Pelajaran</th>
                <th class="px-4 py-2">Skor</th>
                <th class="px-4 py-2">Grade Point</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grades as $gr): ?>
            <tr>
                <td class="border px-4 py-2"><?= $gr['id'] ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($gr['full_name']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($gr['subject']) ?></td>
                <td class="border px-4 py-2"><?= $gr['score'] ?></td>
                <td class="border px-4 py-2"><?= number_format($gr['grade_point'], 2) ?></td>
                <td class="border px-4 py-2 space-x-2">
                    <a href="grades.php?action=edit&id=<?= $gr['id'] ?>" class="text-blue-500">Edit</a>
                    <a href="grades.php?action=delete&id=<?= $gr['id'] ?>" class="text-red-500" onclick="return confirm('Yakin ingin hapus?');">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'templates/footer.php'; ?>
