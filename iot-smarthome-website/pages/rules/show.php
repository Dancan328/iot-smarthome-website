<?php
include_once '../../includes/functions.php';
include_once '../../classes/Rule.php';
include_once '../../classes/Device.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

if (isset($_GET['id'])) {
    $ruleId = sanitizeInput($_GET['id']);
    $rule = Rule::getById($ruleId);

    if ($rule && $rule->getUserId() == getCurrentUserId()) {
        $device = Device::getById($rule->getCondition());
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
    <title>IoT SmartHome - Rule Details</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Rule Details</h1>

    <table>
        <tr>
            <th>ID:</th>
            <td><?php echo $rule->getId(); ?></td>
        </tr>
        <tr>
            <th>Name:</th>
            <td><?php echo $rule->getName(); ?></td>
        </tr>
        <tr>
            <th>Condition:</th>
            <td><?php echo $device->getName(); ?></td>
        </tr>
        <tr>
            <th>Action:</th>
            <td><?php echo $rule->getAction(); ?></td>
        </tr>
    </table>

    <a href="edit.php?id=<?php echo $rule->getId(); ?>">Edit</a>
    <a href="delete.php?id=<?php echo $rule->getId(); ?>">Delete</a>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
