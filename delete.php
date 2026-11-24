<?php require 'db.php'; ?>
<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    set_flash('error', 'Student not found.');
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $stmt->execute([$id]);
    set_flash('success', 'Student deleted successfully.');
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Delete Student</h1>
    <nav><a href="index.php">Home</a><a href="search.php">Search</a></nav>
</header>
<div class="container">
    <form method="post">
        <p>Are you sure you want to delete this student?</p>
        <p><strong><?= clean($student['name']) ?></strong> - <?= clean($student['email']) ?></p>
        <button class="btn btn-danger" type="submit">Yes, Delete</button>
        <a class="btn" href="index.php">Cancel</a>
    </form>
</div>
</body>
</html>
