<?php session_start(); ?>
<?php if (!isset($_SESSION['Active']) || !$_SESSION['Active']): ?>
    <?php header('Location: /public/login.php'); exit; ?>
<?php endif; ?>

<link rel="stylesheet" href="../css/header.css">

<?php if (isset($_SESSION['admin_id'])): ?>
    <a href="/admin/admin_dashboard.php">Admin Dashboard</a>
    <a href="/authentication/logout/logout.php">Log Out</a>
<?php elseif (isset($_SESSION['user_id'])): ?>
    <a href="/public/index.php">Home</a>
    <a href="/dashboard/dashboard.php">My Dashboard</a>
    <a href="/public/contact.php">Contact</a>
    <a href="/public/aboutus.php">About Us</a>
    <a href="/authentication/logout/logout.php">Log Out</a>
<?php else: ?>
    <a href="/public/login.php">Login</a>
<?php endif; ?>

<div class="search-container">
    <form action="/dogs/search.php" method="GET">
    </form>
</div>
