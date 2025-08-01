<?php
session_start();
if ($_SESSION['role'] !== 'desk') {
    die("❌ Unauthorized access.");
}
echo "<h2>📦 Welcome Desk Admin: " . $_SESSION['username'] . "</h2>";