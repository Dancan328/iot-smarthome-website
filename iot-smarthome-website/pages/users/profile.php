<?php
include_once '../../includes/functions.php';
include_once '../../classes/User.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

$userId = getCurrentUserId();
$user = User::getById($userId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->save();
        $success = "Profile updated successfully.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - User Profile</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>User Profile</h1>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <?php if (isset($success)) { ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name: <input type="text" name="name" value="<?php echo $user->getName(); ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo $user->getEmail(); ?>" required><br>
        Password: <input type="password" name="password" required><br>
        Confirm Password: <input type="password" name="confirm_password" required><br>
        <input type="submit" name="submit" value="Update Profile">
    </form>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
