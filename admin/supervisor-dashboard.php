<?php
session_start();
if ($_SESSION['role'] !== 'supervisor') {
    die("❌ Unauthorized access.");
}
echo "<h2>🛡️ Welcome Supervisor Admin: " . $_SESSION['username'] . "</h2>";