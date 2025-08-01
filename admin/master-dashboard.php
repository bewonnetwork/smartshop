<?php
session_start();
if ($_SESSION['role'] !== 'master') {
    die("❌ Unauthorized access.");
}
echo "<h2>👑 Welcome Master Admin: " . $_SESSION['admin'] . "</h2>