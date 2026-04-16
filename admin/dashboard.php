<?php
session_start();
require_once '../includes/auth.php';
requireLogin();
require_once '../includes/db.php';

// Stats
$total      = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
$new        = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status='new'")->fetchColumn();
$contacted  = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status='contacted'")->fetchColumn();
$closed     = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status='closed'")->fetchColumn();

// Recent 5
$recent = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard – TaxSafar Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">

<?php include 'partials/sidebar.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Dashboard</h1>
        <span>Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?> | <a href="logout.php">Logout</a></span>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="card card-blue"><h3><?= $total ?></h3><p>Total Inquiries</p></div>
        <div class="card card-green"><h3><?= $new ?></h3><p>New</p></div>
        <div class="card card-yellow"><h3><?= $contacted ?></h3><p>Contacted</p></div>
        <div class="card card-red"><h3><?= $closed ?></h3><p>Closed</p></div>
    </div>

    <!-- Recent Inquiries -->
    <div class="table-section">
        <h2>Recent Inquiries</h2>
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Service</th><th>Status</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php foreach ($recent as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['service']) ?></td>
                    <td><span class="badge badge-<?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                    <td><a href="edit_inquiry.php?id=<?= $row['id'] ?>" class="btn-sm">Edit</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="inquiries.php" class="btn-primary" style="margin-top:1rem;display:inline-block">View All →</a>
    </div>
</main>
</body>
</html>