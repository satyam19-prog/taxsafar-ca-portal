<?php
session_start();
require_once '../includes/auth.php';
requireLogin();
require_once '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header("Location: inquiries.php"); exit(); }

$stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = :id");
$stmt->execute([':id' => $id]);
$inquiry = $stmt->fetch();
if (!$inquiry) { header("Location: inquiries.php"); exit(); }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $mobile    = trim($_POST['mobile']);
    $city      = trim($_POST['city']);
    $service   = trim($_POST['service']);
    $message   = trim($_POST['message']);
    $status    = $_POST['status'];

    if (empty($full_name) || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || !preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
        $error = "Please check your inputs.";
    } else {
        $upd = $pdo->prepare("
            UPDATE inquiries SET full_name=:fn, email=:em, mobile=:mo,
            city=:ci, service=:sv, message=:msg, status=:st WHERE id=:id
        ");
        $upd->execute([
            ':fn' => htmlspecialchars($full_name), ':em' => $email,
            ':mo' => $mobile, ':ci' => htmlspecialchars($city),
            ':sv' => $service, ':msg' => htmlspecialchars($message),
            ':st' => $status, ':id' => $id
        ]);
        $_SESSION['msg'] = "Inquiry updated successfully!";
        header("Location: inquiries.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Inquiry – TaxSafar Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">
<?php include 'partials/sidebar.php'; ?>
<main class="admin-main">
    <div class="admin-header"><h1>Edit Inquiry #<?= $id ?></h1><a href="inquiries.php">← Back</a></div>
    <?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
    <div class="form-card">
    <form method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($inquiry['full_name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($inquiry['email']) ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Mobile</label>
                <input type="tel" name="mobile" value="<?= htmlspecialchars($inquiry['mobile']) ?>" required>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="<?= htmlspecialchars($inquiry['city']) ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Service</label>
                <select name="service">
                    <?php foreach (['ITR Filing','GST Registration','PAN Card Services','Company Registration','Accounting & Bookkeeping','Tax Consultation','Other'] as $svc): ?>
                        <option <?= $inquiry['service'] === $svc ? 'selected' : '' ?>><?= $svc ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <?php foreach (['new','contacted','closed'] as $st): ?>
                        <option value="<?= $st ?>" <?= $inquiry['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea name="message" rows="4"><?= htmlspecialchars($inquiry['message']) ?></textarea>
        </div>
        <button type="submit" class="btn-primary">Update Inquiry</button>
    </form>
    </div>
</main>
</body>
</html>