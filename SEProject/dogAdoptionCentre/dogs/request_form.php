<?php require_once '../template/header.php'; ?>

<style>
    <?php require '../css/navbar.css'; ?>
</style>

<?php
require '../lib/db.php';
$db = new Database();
$pdo = $db->getConnection();

$dogID = $_GET['id'] ?? null;
if (!$dogID) {
    echo "Invalid dog ID.";
    exit;
}

// Fetch dog details
$stmt = $pdo->prepare("SELECT * FROM dogs WHERE id = :id");
$stmt->bindParam(':id', $dogID);
$stmt->execute();
$dog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dog) {
    echo "Dog not found.";
    exit;
}

$userID = $_SESSION['user_id'];
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    $agreements = $_POST['agreements'] ?? [];

    // Validate input
    if (empty($message)) {
        $errors[] = "Please provide a reason for adopting.";
    }

    if (count($agreements) < 3) {
        $errors[] = "You must agree to all terms.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO adoption_requests (user_id, dog_id, status, request_date) 
                               VALUES (:user_id, :dog_id, 'Pending', NOW())");
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':dog_id', $dogID);
        $stmt->execute();

        // Optionally: store the message somewhere if you plan to support it
        header('Location: ../dashboard/dashboard.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Adoption</title>
    <link rel="stylesheet" href="/css/theme.css">

</head>
<body>
<div class="container">
    <div class="house">
        <h2>Adopt <?php echo htmlspecialchars($dog['name']); ?></h2>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <p>Why do you want to adopt <strong><?php echo htmlspecialchars($dog['name']); ?></strong>?</p>
            <textarea name="message" rows="5" style="width:100%;" placeholder="Tell us why..."><?php echo htmlspecialchars($_POST['message'] ?? '') ?></textarea>

            <p>Please confirm the following:</p>
            <label><input type="checkbox" name="agreements[]" value="care"> I agree to provide daily food and water.</label><br>
            <label><input type="checkbox" name="agreements[]" value="vet"> I agree to provide regular vet checkups and vaccinations.</label><br>
            <label><input type="checkbox" name="agreements[]" value="home"> I agree to provide a safe and loving home.</label><br>

            <br>
            <button type="submit" class="button">Yes, Send Request</button>
            <a href="/public/index.php" class="button">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>
