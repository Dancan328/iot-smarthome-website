<?php
include_once '../../includes/functions.php';
include_once '../../classes/Rule.php';
include_once '../../classes/Device.php';

session_start();
redirectIfNotLoggedIn("../auth/login.php");

$devices = Device::getAll(getCurrentUserId());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $condition = sanitizeInput($_POST["condition"]);
    $action = sanitizeInput($_POST["action"]);

    $rule = new Rule(null, $name, $condition, $action, getCurrentUserId());
    $rule->save();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome - Create Rule</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Create Rule</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name: <input type="text" name="name" required><br>
        Condition: <select name="condition" required>
            <option value="">Select a device</option>
            <?php foreach ($devices as $device) { ?>
                <option value="<?php echo $device->getId(); ?>"><?php echo $device->getName(); ?></option>
            <?php } ?>
        </select><br>
        Action: <input type="text" name="action" required><br>
        <input type="submit" name="submit" value="Create">
    </form>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
