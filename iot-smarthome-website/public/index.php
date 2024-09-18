<?php
include_once '../includes/functions.php';
include_once '../classes/Device.php';
include_once '../classes/Rule.php';

session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <?php include_once '../pages/layouts/header.php'; ?>

    <main>
        <section>
            <h1>Welcome to IoT SmartHome</h1>
            <p>Discover the power of the Internet of Things and take control of your smart home.</p>
            <?php if (isLoggedIn()) { ?>
                <a href="pages/devices/index.php">Manage Your Devices</a>
            <?php } else { ?>
                <a href="pages/auth/login.php">Login</a>
                <a href="pages/auth/register.php">Register</a>
            <?php } ?>
        </section>

        <section>
            <h2>Featured Devices</h2>
            <?php
            $devices = Device::getLatest(1);
            foreach ($devices as $device) {
                echo "<div>";
                echo "<h3>" . $device->getName() . "</h3>";
                echo "<p>Type: " . $device->getType() . "</p>";
                echo "<p>Status: " . $device->getStatus() . "</p>";
                echo "</div>";
            }
            ?>
        </section>

        <section>
            <h2>Latest Rules</h2>
            <?php
            $rules = Rule::getLatest(3);
            foreach ($rules as $rule) {
                $device = Device::getById($rule->getCondition());
                echo "<div>";
                echo "<h3>" . $rule->getName() . "</h3>";
                echo "<p>Condition: " . $device->getName() . "</p>";
                echo "<p>Action: " . $rule->getAction() . "</p>";
                echo "</div>";
            }
            ?>
        </section>
    </main>

    <?php include_once '../pages/layouts/footer.php'; ?>

    <script>
        // Add your JavaScript code here
    </script>
</body>
</html>
