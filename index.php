<?php
require __DIR__ . '/loginPortal/auth.php';

check_login();

$title = 'Web Programming 1';
ob_start();
include 'templates/home.html.php';
$output = ob_get_clean();

include_layout();
?>