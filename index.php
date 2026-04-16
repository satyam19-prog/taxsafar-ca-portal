<?php
session_start();
$success = $_SESSION['form_success'] ?? '';
$error   = $_SESSION['form_error']   ?? '';
unset($_SESSION['form_success'], $_SESSION['form_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxSafar – Smart Tax & Financial Services</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="container nav-inner">
        <div class="logo">💼 TaxSafar</div>
        <ul class="nav-links">
            <li><a href="#services">Services</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <h1>Simplifying Tax & Financial Services</h1>
        <p>ITR Filing, GST Registration, PAN Card, Company Registration & more — all in one place.</p>
        <a href="#contact" class="btn-primary">Get Free Consultation</a>
    </div>
</section>

<!-- SERVICES -->
<section class="services" id="services">
    <div class="container">
        <h2>Our Services</h2>
        <div class="services-grid">
            <?php
            $services = [
                ["📄","ITR Filing","Quick and accurate income tax return filing."],
                ["🏢","GST Registration","End-to-end GST registration and compliance."],
                ["🪪","PAN Card","Apply or update your PAN card easily."],
                ["🏗️","Company Registration","Register your business hassle-free."],
                ["📊","Accounting","Professional bookkeeping and accounting."],
                ["🤝","Tax Consultation","Expert advice for all your tax queries."],
            ];
            foreach ($services as $s): ?>
            <div class="service-card">
                <span class="icon"><?= $s[0] ?></span>
                <h3><?= $s[1] ?></h3>
                <p><?= $s[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="about" id="about">
    <div class="container about-inner">
        <div>
            <h2>Why Choose TaxSafar?</h2>
            <ul class="why-list">
                <li>✅ 10,000+ Happy Clients Across India</li>
                <li>✅ Certified CA & Tax Experts</li>
                <li>✅ 100% Secure & Confidential</li>
                <li>✅ Affordable & Transparent Pricing</li>
                <li>✅ Fast Turnaround Time</li>
            </ul>
        </div>
        <div class="stats-box">
            <div class="stat"><h3>10K+</h3><p>Clients Served</p></div>
            <div class="stat"><h3>5+</h3><p>Years Experience</p></div>
            <div class="stat"><h3>20+</h3><p>Services Offered</p></div>
            <div class="stat"><h3>98%</h3><p>Satisfaction Rate</p></div>
        </div>
    </div>
</section>

<!-- INQUIRY FORM -->
<section class="contact" id="contact">
    <div class="container">
        <h2>Get In Touch</h2>
        <p class="subtitle">Fill the form below and our expert will contact you shortly.</p>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="submit_inquiry.php" method="POST" class="inquiry-form" id="inquiryForm">
            <div class="form-row">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" placeholder="john@email.com" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Mobile Number *</label>
                    <input type="tel" name="mobile" placeholder="10-digit mobile" pattern="[6-9][0-9]{9}" required>
                </div>
                <div class="form-group">
                    <label>City *</label>
                    <input type="text" name="city" placeholder="Your city" required>
                </div>
            </div>
            <div class="form-group">
                <label>Service Required *</label>
                <select name="service" required>
                    <option value="">-- Select Service --</option>
                    <option>ITR Filing</option>
                    <option>GST Registration</option>
                    <option>PAN Card Services</option>
                    <option>Company Registration</option>
                    <option>Accounting & Bookkeeping</option>
                    <option>Tax Consultation</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="4" placeholder="Tell us more about your requirement..."></textarea>
            </div>
            <button type="submit" class="btn-primary btn-full">Submit Inquiry →</button>
        </form>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <p>© 2025 TaxSafar | Operated by Swilesure Private Limited | All rights reserved.</p>
    </div>
</footer>

<script src="assets/js/script.js"></script>
</body>
</html>