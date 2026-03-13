<?php
// pages/liste_enseignants.php - Liste des enseignants
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Liste des enseignants';

try {
    $stmt = $pdo->query("SELECT e.*, c.nom as classe_nom FROM enseignants e LEFT JOIN classes c ON e.classe_id = c.id ORDER BY e.nom");
    $enseignants = $stmt->fetchAll();
} catch (PDOException $e) {
    $enseignants = [];
}

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Liste des enseignants</h2>
    <a href="ajouter_enseignant.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un enseignant
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="enseignantsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Cours</th>
                    <th>Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enseignants as $enseignant): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($enseignant['nom']); ?></td>
                        <td><?php echo htmlspecialchars($enseignant['telephone'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($enseignant['cours'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($enseignant['classe_nom'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="modifier_enseignant.php?id=<?php echo $enseignant['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="supprimer_enseignant.php?id=<?php echo $enseignant['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#enseignantsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            }
        });
    });
</script>

<?php include '../includes/footer.php'; ?>