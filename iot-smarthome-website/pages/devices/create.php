<?php
include_once '../../includes/functions.php';
include_once '../../classes/Device.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $type = sanitizeInput($_POST["type"]);
    $status = sanitizeInput($_POST["status"]);

    $device = new Device(null, $name, $type, $status, getCurrentUserId());
    $device->save();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - Create Device</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Create Device</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name: <input type="text" name="name" required><br>
        Type: <input type="text" name="type" required><br>
        Status: <input type="text" name="status" required><br>
        <input type="submit" name="submit" value="Create">
    </form>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
