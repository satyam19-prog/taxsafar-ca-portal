<aside class="sidebar">
    <div class="brand">💼 TaxSafar</div>
    <a href="dashboard.php"  class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php'  ? 'active':'' ?>">📊 Dashboard</a>
    <a href="inquiries.php"  class="<?= basename($_SERVER['PHP_SELF']) === 'inquiries.php'  ? 'active':'' ?>">📋 Inquiries</a>
    <a href="../index.php" target="_blank">🌐 View Site</a>
    <a href="logout.php" style="margin-top:auto;color:#f87171;">🚪 Logout</a>
</aside>