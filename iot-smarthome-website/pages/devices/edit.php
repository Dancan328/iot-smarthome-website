<?php
include_once '../../includes/functions.php';
include_once '../../classes/Device.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

if (isset($_GET['id'])) {
    $deviceId = sanitizeInput($_GET['id']);
    $device = Device::getById($deviceId);

    if ($device && $device->getUserId() == getCurrentUserId()) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = sanitizeInput($_POST["name"]);
            $type = sanitizeInput($_POST["type"]);
            $status = sanitizeInput($_POST["status"]);

            $device->setName($name);
            $device->setType($type);
            $device->setStatus($status);
            $device->save();

            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - Edit Device</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Edit Device</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $device->getId(); ?>">
        Name: <input type="text" name="name" value="<?php echo $device->getName(); ?>" required><br>
        Type: <input type="text" name="type" value="<?php echo $device->getType(); ?>" required><br>
        Status: <input type="text" name="status" value="<?php echo $device->getStatus(); ?>" required><br>
        <input type="submit" name="submit" value="Update">
    </form>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
