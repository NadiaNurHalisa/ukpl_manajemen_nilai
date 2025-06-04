<?php
require_once 'functions/auth.php';
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!login($_POST['username'], $_POST['password'])) {
        $error = 'Invalid credentials';
    } else {
        header('Location: dashboard.php');
        exit;
    }
}
?>

<?php include 'templates/header.php'; ?>
<div class="max-w-md mx-auto bg-white shadow p-8 rounded">
    <h2 class="text-2xl font-bold mb-6">Login</h2>
    <?php if ($error): ?>
        <p class="text-red-500"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST">
        <div class="mb-4">
            <label class="block mb-1">Username</label>
            <input type="text" name="username" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="mb-6">
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Login</button>
    </form>
    <p class="mt-4 text-center">
        Belum punya akun? <a href="register.php" class="text-blue-500">Register di sini</a>
    </p>
</div>
<?php include 'templates/footer.php'; ?>