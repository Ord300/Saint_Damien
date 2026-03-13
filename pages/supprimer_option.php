<?php
// pages/supprimer_option.php - Supprimer une option
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';

$id = $_GET['id'] ?? 0;

if (!$id) {
    header('Location: liste_options.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM options WHERE id = ?");
    $stmt->execute([$id]);
} catch (PDOException $e) {
    // Gérer l'erreur si nécessaire
}

header('Location: liste_options.php');
exit;
?>