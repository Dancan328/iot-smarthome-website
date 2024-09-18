<?php
include_once '../../includes/functions.php';
include_once '../../classes/User.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

$userId = getCurrentUserId();
$user = User::getById($userId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $darkMode = isset($_POST["dark_mode"]) ? 1 : 0;
    $emailNotifications = isset($_POST["email_notifications"]) ? 1 : 0;

    $user->setDarkMode($darkMode);
    $user->setEmailNotifications($emailNotifications);
    $user->save();

    $success = "Settings updated successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - User Settings</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>User Settings</h1>

    <?php if (isset($success)) { ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Dark Mode: <input type="checkbox" name="dark_mode" <?php if ($user->getDarkMode()) echo "checked"; ?>><br>
        Email Notifications: <input type="checkbox" name="email_notifications" <?php if ($user->getEmailNotifications()) echo "checked"; ?>><br>
        <input type="submit" name="submit" value="Save Settings">
    </form>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
