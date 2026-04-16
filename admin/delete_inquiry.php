<?php
session_start();
require_once '../includes/auth.php';
requireLogin();
require_once '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $_SESSION['msg'] = "Inquiry deleted successfully.";
}
header("Location: inquiries.php");
exit();