<?php require_once '../template/header.php'; ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../public/login.php');
    exit;
}

require '../lib/db.php';
require '../classes/User.php';

$db = new Database();
$pdo = $db->getConnection();
$userModel = new User($pdo);

$messages = $userModel->getAllMessagesWithUserInfo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Messages</title>
    <link rel="stylesheet" href="../css/theme.css">
</head>
<body>
<div class="container">
    <h2>User Messages</h2>
    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $msg): ?>
            <div style="margin-bottom: 20px;">
                <strong><?= htmlspecialchars($msg['subject']) ?></strong>
                from <?= htmlspecialchars($msg['first_name']) ?> (<?= htmlspecialchars($msg['email']) ?>)
                <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                <small>Sent: <?= htmlspecialchars($msg['sent_at']) ?></small>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>
</div>
</body>
</html>
