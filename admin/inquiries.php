<?php
session_start();
require_once '../includes/auth.php';
requireLogin();
require_once '../includes/db.php';

$search = trim($_GET['search'] ?? '');
$status = $_GET['status'] ?? '';
$msg    = $_SESSION['msg'] ?? '';
unset($_SESSION['msg']);

$params = [];
$sql    = "SELECT * FROM inquiries WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (full_name LIKE :s OR email LIKE :s OR mobile LIKE :s)";
    $params[':s'] = "%$search%";
}
if (!empty($status) && in_array($status, ['new','contacted','closed'])) {
    $sql .= " AND status = :status";
    $params[':status'] = $status;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$inquiries = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inquiries – TaxSafar Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">

<?php include 'partials/sidebar.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>All Inquiries</h1>
        <a href="logout.php">Logout</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- Search + Filter -->
    <form method="GET" class="filter-bar">
        <input type="text" name="search" placeholder="Search name, email, mobile..." value="<?= htmlspecialchars($search) ?>">
        <select name="status">
            <option value="">All Status</option>
            <option value="new"       <?= $status === 'new'       ? 'selected' : '' ?>>New</option>
            <option value="contacted" <?= $status === 'contacted' ? 'selected' : '' ?>>Contacted</option>
            <option value="closed"    <?= $status === 'closed'    ? 'selected' : '' ?>>Closed</option>
        </select>
        <button type="submit" class="btn-primary">Filter</button>
        <a href="inquiries.php" class="btn-outline">Reset</a>
    </form>

    <table class="data-table">
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Mobile</th><th>City</th><th>Service</th><th>Status</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php if (empty($inquiries)): ?>
            <tr><td colspan="9" style="text-align:center">No inquiries found.</td></tr>
        <?php else: ?>
        <?php foreach ($inquiries as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['full_name']) ?></td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><?= htmlspecialchars($r['mobile']) ?></td>
                <td><?= htmlspecialchars($r['city']) ?></td>
                <td><?= htmlspecialchars($r['service']) ?></td>
                <td><span class="badge badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                <td>
                    <a href="edit_inquiry.php?id=<?= $r['id'] ?>" class="btn-sm btn-edit">Edit</a>
                    <a href="delete_inquiry.php?id=<?= $r['id'] ?>" class="btn-sm btn-danger"
                       onclick="return confirm('Delete this inquiry?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>