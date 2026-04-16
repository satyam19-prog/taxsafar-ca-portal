<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Sanitize & Validate
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email']     ?? '');
$mobile    = trim($_POST['mobile']    ?? '');
$city      = trim($_POST['city']      ?? '');
$service   = trim($_POST['service']   ?? '');
$message   = trim($_POST['message']   ?? '');

$errors = [];

if (empty($full_name) || strlen($full_name) < 2)
    $errors[] = "Full name must be at least 2 characters.";

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = "Please enter a valid email address.";

if (!preg_match('/^[6-9][0-9]{9}$/', $mobile))
    $errors[] = "Please enter a valid 10-digit Indian mobile number.";

if (empty($city))
    $errors[] = "City is required.";

if (empty($service))
    $errors[] = "Please select a service.";

if (!empty($errors)) {
    $_SESSION['form_error'] = implode(' | ', $errors);
    header("Location: index.php#contact");
    exit();
}

// Insert using prepared statement
try {
    $stmt = $pdo->prepare("
        INSERT INTO inquiries (full_name, email, mobile, city, service, message, status)
        VALUES (:full_name, :email, :mobile, :city, :service, :message, 'new')
    ");
    $stmt->execute([
        ':full_name' => htmlspecialchars($full_name),
        ':email'     => $email,
        ':mobile'    => $mobile,
        ':city'      => htmlspecialchars($city),
        ':service'   => $service,
        ':message'   => htmlspecialchars($message),
    ]);

    $_SESSION['form_success'] = "✅ Thank you! Your inquiry has been submitted. We'll contact you shortly.";
} catch (PDOException $e) {
    $_SESSION['form_error'] = "Something went wrong. Please try again.";
}

header("Location: index.php#contact");
exit();