<?php
// logout.php - Déconnexion
session_start();
session_destroy();
header('Location: login.php');
exit;
?>