<?php require_once '../template/header.php'; ?>

<style>
    <?php require '../css/navbar.css'; ?>
</style>

<?php
require '../lib/db.php';
$db = new Database();
$pdo = $db->getConnection();

// Get dog ID from query param
if (!isset($_GET['id'])) {
    echo "Dog not found.";
    exit;
}

$dogID = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM dogs WHERE id = :id");
$stmt->bindParam(':id', $dogID);
$stmt->execute();
$dog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dog) {
    echo "Dog not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($dog['name']); ?> - Details</title>
    <link rel="stylesheet" href="/css/theme.css">

</head>
<body>
<?php require '../template/header.php'; ?>
<div class="container">
    <div class="house">
        <img src="<?php echo htmlspecialchars($dog['image']); ?>" alt="<?php echo htmlspecialchars($dog['name']); ?>">
        <h2><?php echo htmlspecialchars($dog['name']); ?></h2>
        <p><strong>Breed:</strong> <?php echo htmlspecialchars($dog['breed']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($dog['age']); ?> years</p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($dog['gender']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($dog['description']); ?></p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="request_form.php?id=<?php echo $dog['id']; ?>" class="button">Adopt Me</a>
        <?php else: ?>
            <p><a href="../public/login.php" class="button">Log in to adopt</a></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
