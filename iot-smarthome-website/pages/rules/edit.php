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
        $devices = Device::getAll(getCurrentUserId());

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = sanitizeInput($_POST["name"]);
            $condition = sanitizeInput($_POST["condition"]);
            $action = sanitizeInput($_POST["action"]);

            $rule->setName($name);
            $rule->setCondition($condition);
            $rule->setAction($action);
            $rule->save();

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
    <title>IoT SmartHome - Edit Rule</title>
</head>
<body>
    <?php include_once '../layouts/header.php'; ?>

    <h1>Edit Rule</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $rule->getId(); ?>">
        Name: <input type="text" name="name" value="<?php echo $rule->getName(); ?>" required><br>
        Condition: <select name="condition" required>
            <option value="">Select a device</option>
            <?php foreach ($devices as $device) { ?>
                <option value="<?php echo $device->getId(); ?>" <?php if ($device->getId() == $rule->getCondition()) echo "selected"; ?>>
                    <?php echo $device->getName(); ?>
                </option>
            <?php } ?>
        </select><br>
        Action: <input type="text" name="action" value="<?php echo $rule->getAction(); ?>" required><br>
        <input type="submit" name="submit" value="Update">
    </form>

    <?php include_once '../layouts/footer.php'; ?>
</body>
</html>
