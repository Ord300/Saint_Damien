<?php
// pages/liste_classes.php - Liste des classes
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Liste des classes';

try {
    $stmt = $pdo->query("SELECT c.*, COUNT(e.id) as nombre_eleves FROM classes c LEFT JOIN eleves e ON c.id = e.classe_id GROUP BY c.id ORDER BY c.nom");
    $classes = $stmt->fetchAll();
} catch (PDOException $e) {
    $classes = [];
}

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Liste des classes</h2>
    <a href="ajouter_classe.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter une classe
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="classesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Niveau</th>
                    <th>Nombre d'élèves</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $classe): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($classe['nom']); ?></td>
                        <td><?php echo htmlspecialchars($classe['niveau']); ?></td>
                        <td><?php echo $classe['nombre_eleves']; ?></td>
                        <td>
                            <a href="modifier_classe.php?id=<?php echo $classe['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="supprimer_classe.php?id=<?php echo $classe['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">
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
        $('#classesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            }
        });
    });
</script>

<?php include '../includes/footer.php'; ?>