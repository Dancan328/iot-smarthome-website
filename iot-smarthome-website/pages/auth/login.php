<?php
include_once '../../includes/functions.php';
include_once '../../classes/User.php';

session_start();

if (isLoggedIn()) {
    header("Location: ../devices/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];

    $user = User::getByEmail($email);
    if ($user && $user->validatePassword($password)) {
        $_SESSION['user_id'] = $user->getId();
        header("Location: ../devices/index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - Login</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Login</h1>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="submit" value="Login">
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
