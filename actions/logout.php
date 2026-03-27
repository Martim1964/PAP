<?php
session_start();
// destroy all session data and redirect to homepage

session_unset();
session_destroy();
header('Location: ../index.php');
exit;
?>
