<?php
include_once '../../includes/functions.php';
include_once '../../classes/Rule.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

$rules = Rule::getAll(getCurrentUserId());
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - Rules</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Rules</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Condition</th>
                <th>Action</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rules as $rule) { ?>
            <tr>
                <td><?php echo $rule->getId(); ?></td>
                <td><?php echo $rule->getName(); ?></td>
                <td><?php echo $rule->getCondition(); ?></td>
                <td><?php echo $rule->getAction(); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $rule->getId(); ?>">Edit</a>
                    <a href="delete.php?id=<?php echo $rule->getId(); ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="create.php">Add New Rule</a>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
