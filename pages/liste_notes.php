<?php
// pages/liste_notes.php - Liste des notes
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Liste des notes';

// Calcul des moyennes
try {
    $stmt = $pdo->query("
        SELECT e.id, CONCAT(e.nom, ' ', e.prenom) as nom_complet, 
               AVG(n.note) as moyenne, COUNT(n.id) as nombre_notes
        FROM eleves e 
        LEFT JOIN notes n ON e.id = n.eleve_id 
        GROUP BY e.id, e.nom, e.prenom 
        ORDER BY e.nom
    ");
    $moyennes = $stmt->fetchAll();

    $stmt = $pdo->query("SELECT n.*, CONCAT(e.nom, ' ', e.prenom) as eleve_nom, c.nom as cours_nom FROM notes n JOIN eleves e ON n.eleve_id = e.id JOIN cours c ON n.cours_id = c.id ORDER BY n.date_evaluation DESC");
    $notes = $stmt->fetchAll();
} catch (PDOException $e) {
    $moyennes = [];
    $notes = [];
}

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Liste des notes</h2>
    <a href="ajouter_note.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter une note
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Moyennes par élève</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Moyenne</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($moyennes as $moyenne): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($moyenne['nom_complet']); ?></td>
                                <td><?php echo $moyenne['moyenne'] ? number_format($moyenne['moyenne'], 2) : 'N/A'; ?></td>
                                <td><?php echo $moyenne['nombre_notes']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Toutes les notes</h5>
            </div>
            <div class="card-body">
                <table id="notesTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Cours</th>
                            <th>Note</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes as $note): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($note['eleve_nom']); ?></td>
                                <td><?php echo htmlspecialchars($note['cours_nom']); ?></td>
                                <td><?php echo $note['note']; ?>/20</td>
                                <td><?php echo date('d/m/Y', strtotime($note['date_evaluation'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#notesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            },
            "pageLength": 10
        });
    });
</script>

<?php include '../includes/footer.php'; ?>