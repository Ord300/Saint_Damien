<?php
// pages/supprimer_utilisateur.php - Supprimer un utilisateur
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';

$id = $_GET['id'] ?? 0;

if (!$id || $id == $_SESSION['user_id']) {
    header('Location: liste_utilisateurs.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
} catch (PDOException $e) {
    // Gérer l'erreur si nécessaire
}

header('Location: liste_utilisateurs.php');
exit;
?>