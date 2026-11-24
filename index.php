<?php require 'db.php'; ?>
<?php
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$total_stmt = $pdo->query('SELECT COUNT(*) FROM students');
$total_students = $total_stmt->fetchColumn();
$total_pages = ceil($total_students / $limit);

$stmt = $pdo->prepare('SELECT * FROM students ORDER BY id DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Student Management System</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="add.php">Add Student</a>
        <a href="search.php">Search</a>
    </nav>
</header>
<div class="container">
    <?php show_flash(); ?>
    <a class="btn" href="add.php">+ Add New Student</a>
    <br><br>
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
                <tr><td colspan="7" class="empty">No students found.</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a class="<?= $i == $page ? 'active' : '' ?>" href="index.php?page=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
</body>
</html>
