<?php require_once '../template/header.php'; ?>

<?php
require '../lib/db.php';

// Connect to DB and fetch all dogs
$db = new Database();
$pdo = $db->getConnection();

$stmt = $pdo->prepare("SELECT * FROM dogs WHERE is_available = TRUE ORDER BY created_at DESC");
$stmt->execute();
$dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/theme.css">

    <title>Available Dogs</title>
</head>
<body>
<h1>Meet Our Dogs</h1>
<div class="container">
    <?php foreach ($dogs as $dog): ?>
        <div class="house">
            <img src="<?php echo htmlspecialchars($dog['image']); ?>" alt="<?php echo htmlspecialchars($dog['name']); ?>">
            <h2><?php echo htmlspecialchars($dog['name']); ?></h2>
            <p><strong>Breed:</strong> <?php echo htmlspecialchars($dog['breed']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($dog['age']); ?> years</p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($dog['gender']); ?></p>
            <a href="/dogs/show.php?id=<?php echo $dog['id']; ?>" class="button">View Details</a>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
