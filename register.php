<?php
require_once 'functions/auth.php';
// Redirect jika sudah login
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username']);
    $password  = $_POST['password'];
    $full_name = trim($_POST['full_name']);
    if (empty($username) || empty($password) || empty($full_name)) {
        $error = 'Semua field wajib diisi.';
    } elseif (!register($username, $password, $full_name)) {
        $error = 'Username sudah digunakan.';
    } else {
        header('Location: index.php');
        exit;
    }
}
?>

<?php include 'templates/header.php'; ?>
<div class="max-w-md mx-auto bg-white shadow p-8 rounded">
    <h2 class="text-2xl font-bold mb-6">Register</h2>
    <?php if ($error): ?><p class="text-red-500"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST" class="space-y-4">
        <div>
            <label class="block mb-1">Nama Lengkap</label>
            <input type="text" name="full_name" class="w-full border px-3 py-2 rounded" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
        </div>
        <div>
            <label class="block mb-1">Username</label>
            <input type="text" name="username" class="w-full border px-3 py-2 rounded" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        </div>
        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
        </div>
        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded">Register</button>
    </form>
    <p class="mt-4 text-center">
        Sudah punya akun? <a href="index.php" class="text-blue-500">Login di sini</a>
    </p>
</div>
<?php include 'templates/footer.php'; ?>
