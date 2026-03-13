<?php
// pages/liste_paiements.php - Liste des paiements
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Liste des paiements';

try {
    $stmt = $pdo->query("SELECT p.*, CONCAT(e.nom, ' ', e.prenom) as eleve_nom FROM paiements p JOIN eleves e ON p.eleve_id = e.id ORDER BY p.date_paiement DESC");
    $paiements = $stmt->fetchAll();
} catch (PDOException $e) {
    $paiements = [];
}

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Liste des paiements</h2>
    <a href="ajouter_paiement.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un paiement
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="paiementsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Montant</th>
                    <th>Type de frais</th>
                    <th>Date de paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paiements as $paiement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($paiement['eleve_nom']); ?></td>
                        <td><?php echo number_format($paiement['montant'], 2); ?> €</td>
                        <td><?php echo htmlspecialchars($paiement['type_frais']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($paiement['date_paiement'])); ?></td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="supprimerPaiement(<?php echo $paiement['id']; ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#paiementsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            }
        });
    });

    function supprimerPaiement(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')) {
            window.location.href = 'supprimer_paiement.php?id=' + id;
        }
    }
</script>

<?php include '../includes/footer.php'; ?>