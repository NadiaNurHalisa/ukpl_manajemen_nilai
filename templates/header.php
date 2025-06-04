<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow mb-8">
      <div class="container mx-auto px-4 py-4 flex justify-between">
        <a href="dashboard.php" class="font-bold text-xl">SGM</a>
        <div>
          <?php if(isset(
          $_SESSION['user'])): ?>
            <span class="mr-4">Hi, <?= htmlspecialchars(
              $_SESSION['user']['full_name']) ?></span>
            <a href="logout.php" class="text-red-500">Logout</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
    <div class="container mx-auto px-4">
