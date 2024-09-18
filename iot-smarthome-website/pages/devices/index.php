<?php
include_once '../../includes/functions.php';
include_once '../../classes/Device.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

$devices = Device::getAll(getCurrentUserId());
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - Devices</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Devices</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devices as $device) { ?>
            <tr>
                <td><?php echo $device->getId(); ?></td>
                <td><?php echo $device->getName(); ?></td>
                <td><?php echo $device->getType(); ?></td>
                <td><?php echo $device->getStatus(); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $device->getId(); ?>">Edit</a>
                    <a href="delete.php?id=<?php echo $device->getId(); ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="create.php">Add New Device</a>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
