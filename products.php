<?php
// products.php wraps around search.php functionality but provides a clean URL
$_GET['query'] = $_GET['query'] ?? '';
include 'search.php';
?>
