<?php require 'db.php'; ?>
<?php
$errors = [];
$name = $email = $major = $phone = '';

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
            $stmt = $pdo->prepare('INSERT INTO students (name, email, major, phone) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $email, $major, $phone]);
            set_flash('success', 'Student added successfully.');
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
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Add Student</h1>
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
        <button class="btn" type="submit">Save Student</button>
        <a class="btn" href="index.php">Back</a>
    </form>
</div>
</body>
</html>
