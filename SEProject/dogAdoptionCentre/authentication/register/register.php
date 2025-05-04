<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration - Dog Adoption</title>
    <link rel="stylesheet" href="../../css/register.css">
</head>
<body>
<div class="form-container">
    <h2>User Registration</h2>
    <form action="register_controller.php" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>
    </form>
    <a href="../../public/login.php" class="back-link">Back to Login</a>
</div>
</body>
</html>
