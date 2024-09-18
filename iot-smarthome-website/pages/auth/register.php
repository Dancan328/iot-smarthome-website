<?php
include_once '../../includes/functions.php';
include_once '../../classes/User.php';

session_start();

if (isLoggedIn()) {
    header("Location: ../devices/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $existingUser = User::getByEmail($email);
        if ($existingUser) {
            $error = "Email already registered.";
        } else {
            $user = new User(null, $name, $email, $password);
            $user->save();
            $_SESSION['user_id'] = $user->getId();
            header("Location: ../devices/index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - Register</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Register</h1>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        Confirm Password: <input type="password" name="confirm_password" required><br>
        <input type="submit" name="submit" value="Register">
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
