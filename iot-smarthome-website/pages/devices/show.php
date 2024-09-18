<?php
include_once '../../includes/functions.php';
include_once '../../classes/Device.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

if (isset($_GET['id'])) {
    $deviceId = sanitizeInput($_GET['id']);
    $device = Device::getById($deviceId);

    if ($device && $device->getUserId() == getCurrentUserId()) {
        // Device found and belongs to the current user
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
    <title>IoT SmartHome - Device Details</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Device Details</h1>

    <table>
        <tr>
            <th>ID:</th>
            <td><?php echo $device->getId(); ?></td>
        </tr>
        <tr>
            <th>Name:</th>
            <td><?php echo $device->getName(); ?></td>
        </tr>
        <tr>
            <th>Type:</th>
            <td><?php echo $device->getType(); ?></td>
        </tr>
        <tr>
            <th>Status:</th>
            <td><?php echo $device->getStatus(); ?></td>
        </tr>
    </table>

    <a href="edit.php?id=<?php echo $device->getId(); ?>">Edit</a>
    <a href="delete.php?id=<?php echo $device->getId(); ?>">Delete</a>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
