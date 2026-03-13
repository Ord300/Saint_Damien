<?php
// pages/liste_options.php - Liste des options
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Liste des options';

try {
    $stmt = $pdo->query("SELECT o.*, COUNT(e.id) as nombre_eleves FROM options o LEFT JOIN eleves e ON o.id = e.option_id GROUP BY o.id ORDER BY o.nom");
    $options = $stmt->fetchAll();
} catch (PDOException $e) {
    $options = [];
}

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Liste des options</h2>
    <a href="ajouter_option.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter une option
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table id="optionsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Nombre d'élèves</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($options as $option): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($option['nom']); ?></td>
                        <td><?php echo htmlspecialchars($option['description'] ?? ''); ?></td>
                        <td><?php echo $option['nombre_eleves']; ?></td>
                        <td>
                            <a href="modifier_option.php?id=<?php echo $option['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="supprimer_option.php?id=<?php echo $option['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette option ?')">
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
        $('#optionsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            }
        });
    });
</script>

<?php include '../includes/footer.php'; ?>