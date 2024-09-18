<?php
include_once 'includes/functions.php';
include_once 'classes/Device.php';
include_once 'classes/Rule.php';

session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>IoT SmartHome</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once 'pages/layouts/header.php'; ?>

    <main>
        <section>
            <h1>Welcome to IoT SmartHome</h1>
            <p>Discover the power of the Internet of Things and take control of your smart home.</p>
            <?php if (isLoggedIn()) { ?>
                <a href="pages/devices/index.php" class="btn">Manage Your Devices</a>
            <?php } else { ?>
                <a href="pages/auth/login.php" class="btn">Login</a>
                <a href="pages/auth/register.php" class="btn">Register</a>
            <?php } ?>
        </section>

        <section>
            <h2>Featured Devices</h2>
            <div class="device-grid">
                <?php
                $devices = getLatestDevices(3);
                foreach ($devices as $device) {
                    echo "<div class='device-card'>";
                    echo "<h3>" . $device->getName() . "</h3>";
                    echo "<p>Type: " . $device->getType() . "</p>";
                    echo "<p>Status: <span class='device-status' data-device-id='" . $device->getId() . "'>" . $device->getStatus() . "</span></p>";
                    echo "</div>";
                }
                ?>
            </div>
        </section>

        <section>
            <h2>Latest Rules</h2>
            <div class="rule-grid">
                <?php
                $rules = getLatestRules(3);
                foreach ($rules as $rule) {
                    $device = Device::getById($rule->getCondition());
                    echo "<div class='rule-card'>";
                    echo "<h3>" . $rule->getName() . "</h3>";
                    echo "<p>Condition: " . $device->getName() . "</p>";
                    echo "<p>Action: " . $rule->getAction() . "</p>";
                    echo "<p>Status: <span class='rule-status' data-rule-id='" . $rule->getId() . "'>Active</span></p>";
                    echo "</div>";
                }
                ?>
            </div>
        </section>
    </main>

    <?php include_once 'pages/layouts/footer.php'; ?>

    <script src="js/script.js"></script>
</body>
</html>
