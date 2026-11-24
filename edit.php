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

$errors = [];
$name = $student['name'];
$email = $student['email'];
$major = $student['major'];
$phone = $student['phone'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $major = trim($_POST['major']);
    $phone = trim($_POST['phone']);

    if ($name == '') $errors[] = 'Name is required.';
    if ($email == '') $errors[] = 'Email is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
    if ($major == '') $errors[] = 'Major is required.';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('UPDATE students SET name = ?, email = ?, major = ?, phone = ? WHERE id = ?');
            $stmt->execute([$name, $email, $major, $phone, $id]);
            set_flash('success', 'Student updated successfully.');
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Email already exists or database error.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Edit Student</h1>
    <nav><a href="index.php">Home</a><a href="search.php">Search</a></nav>
</header>
<div class="container">
    <?php foreach ($errors as $error): ?><div class="alert error"><?= clean($error) ?></div><?php endforeach; ?>
    <form method="post">
        <label>Name</label>
        <input type="text" name="name" value="<?= clean($name) ?>">
        <label>Email</label>
        <input type="email" name="email" value="<?= clean($email) ?>">
        <label>Major</label>
        <input type="text" name="major" value="<?= clean($major) ?>">
        <label>Phone</label>
        <input type="text" name="phone" value="<?= clean($phone) ?>">
        <br><br>
        <button class="btn" type="submit">Update Student</button>
        <a class="btn" href="index.php">Back</a>
    </form>
</div>
</body>
</html>
