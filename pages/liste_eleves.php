<?php
// pages/liste_eleves.php - Liste des élèves
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Liste des élèves';

try {
    $stmt = $pdo->query("SELECT e.*, c.nom as classe_nom, o.nom as option_nom FROM eleves e LEFT JOIN classes c ON e.classe_id = c.id LEFT JOIN options o ON e.option_id = o.id ORDER BY e.nom");
    $eleves = $stmt->fetchAll();
} catch (PDOException $e) {
    $eleves = [];
}

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Liste des élèves</h2>
    <a href="ajouter_eleve.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un élève
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="elevesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom complet</th>
                    <th>Sexe</th>
                    <th>Date naissance</th>
                    <th>Classe</th>
                    <th>Option</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eleves as $eleve): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($eleve['matricule']); ?></td>
                        <td><?php echo htmlspecialchars($eleve['nom'] . ' ' . $eleve['postnom'] . ' ' . $eleve['prenom']); ?></td>
                        <td><?php echo $eleve['sexe'] === 'M' ? 'Masculin' : 'Féminin'; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($eleve['date_naissance'])); ?></td>
                        <td><?php echo htmlspecialchars($eleve['classe_nom'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($eleve['option_nom'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($eleve['telephone'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="modifier_eleve.php?id=<?php echo $eleve['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="supprimer_eleve.php?id=<?php echo $eleve['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">
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
        $('#elevesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            }
        });
    });
</script>

<?php include '../includes/footer.php'; ?>