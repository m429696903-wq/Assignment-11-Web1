<?php require 'db.php'; ?>
<?php
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$students = [];

if ($keyword != '') {
    $search = '%' . $keyword . '%';
    $stmt = $pdo->prepare('SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR major LIKE ? ORDER BY id DESC');
    $stmt->execute([$search, $search, $search]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Search Students</h1>
    <nav><a href="index.php">Home</a><a href="add.php">Add Student</a></nav>
</header>
<div class="container">
    <form method="get">
        <label>Search by name, email, or major</label>
        <input type="text" name="keyword" value="<?= clean($keyword) ?>">
        <br><br>
        <button class="btn" type="submit">Search</button>
        <a class="btn" href="search.php">Clear</a>
    </form>
    <br>

    <?php if ($keyword != ''): ?>
        <div class="table-box">
            <table>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Major</th><th>Phone</th><th>Created</th><th>Actions</th>
                </tr>
                <?php if ($students): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= clean($student['id']) ?></td>
                            <td><?= clean($student['name']) ?></td>
                            <td><?= clean($student['email']) ?></td>
                            <td><?= clean($student['major']) ?></td>
                            <td><?= clean($student['phone']) ?></td>
                            <td><?= clean($student['created_at']) ?></td>
                            <td class="actions">
                                <a class="btn" href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                                <a class="btn btn-danger" href="delete.php?id=<?= $student['id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="empty">No results found.</td></tr>
                <?php endif; ?>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
