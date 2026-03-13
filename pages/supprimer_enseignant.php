<?php
// pages/supprimer_enseignant.php - Supprimer un enseignant
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';

$id = $_GET['id'] ?? 0;

if (!$id) {
    header('Location: liste_enseignants.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM enseignants WHERE id = ?");
    $stmt->execute([$id]);
} catch (PDOException $e) {
    // Gérer l'erreur si nécessaire
}

header('Location: liste_enseignants.php');
exit;
?>