<?php
// pages/liste_utilisateurs.php - Liste des utilisateurs
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Liste des utilisateurs';

try {
    $stmt = $pdo->query("SELECT id, nom, email, role, date_creation FROM utilisateurs ORDER BY nom");
    $utilisateurs = $stmt->fetchAll();
} catch (PDOException $e) {
    $utilisateurs = [];
}

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Liste des utilisateurs</h2>
    <a href="ajouter_utilisateur.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un utilisateur
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="utilisateursTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['email']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $utilisateur['role'] === 'admin' ? 'danger' : ($utilisateur['role'] === 'enseignant' ? 'info' : 'secondary'); ?>">
                                <?php echo ucfirst($utilisateur['role']); ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($utilisateur['date_creation'])); ?></td>
                        <td>
                            <?php if ($utilisateur['id'] != $_SESSION['user_id']): ?>
                                <button class="btn btn-sm btn-danger" onclick="supprimerUtilisateur(<?php echo $utilisateur['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#utilisateursTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            }
        });
    });

    function supprimerUtilisateur(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
            window.location.href = 'supprimer_utilisateur.php?id=' + id;
        }
    }
</script>

<?php include '../includes/footer.php'; ?>