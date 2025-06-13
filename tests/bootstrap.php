<?php
// Prevent session_start warnings from PHPUnit output
ob_start();

// Load the Login class for tests
require_once __DIR__ . '/../classes/login.php';