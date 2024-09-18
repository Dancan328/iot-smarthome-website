<?php
include_once 'includes/functions.php';
include_once 'classes/User.php';
?>

<header>
    <nav>
        <ul>
            <li><a href="../devices/index.php">Devices</a></li>
            <li><a href="../rules/index.php">Rules</a></li>
            <?php if (isLoggedIn()) { ?>
                <li><a href="../auth/logout.php">Logout</a></li>
            <?php } else { ?>
                <li><a href="../auth/login.php">Login</a></li>
                <li><a href="../auth/register.php">Register</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>
