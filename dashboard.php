<?php
require_once 'functions/auth.php';
checkAuth();
?>
<?php include 'templates/header.php'; ?>
<h1 class="text-3xl font-bold mb-6">Dashboard</h1>
<div class="grid grid-cols-3 gap-4">
    <a href="classes.php" class="bg-white shadow p-6 rounded text-center hover:bg-gray-100">Manajemen Kelas</a>
    <a href="students.php" class="bg-white shadow p-6 rounded text-center hover:bg-gray-100">Manajemen Siswa</a>
    <a href="grades.php" class="bg-white shadow p-6 rounded text-center hover:bg-gray-100">Input/Edit Nilai</a>
</div>
<?php include 'templates/footer.php'; ?>
