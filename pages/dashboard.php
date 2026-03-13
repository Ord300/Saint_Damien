<?php
// pages/dashboard.php - Tableau de bord
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Tableau de bord';

// Statistiques
try {
    $stats = [];

    // Nombre d'élèves
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM eleves");
    $stats['eleves'] = $stmt->fetch()['count'];

    // Nombre de classes
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM classes");
    $stats['classes'] = $stmt->fetch()['count'];

    // Finances totales
    $stmt = $pdo->query("SELECT SUM(montant) as total FROM paiements");
    $stats['finances'] = $stmt->fetch()['total'] ?? 0;

    // Nombre d'enseignants
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM enseignants");
    $stats['enseignants'] = $stmt->fetch()['count'];

} catch (PDOException $e) {
    $stats = ['eleves' => 0, 'classes' => 0, 'finances' => 0, 'enseignants' => 0];
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-users"></i> Élèves</h5>
                <h2><?php echo $stats['eleves']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-school"></i> Classes</h5>
                <h2><?php echo $stats['classes']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-money-bill-wave"></i> Finances</h5>
                <h2><?php echo number_format($stats['finances'], 2); ?> €</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Enseignants</h5>
                <h2><?php echo $stats['enseignants']; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Répartition par classe</h5>
            </div>
            <div class="card-body">
                <canvas id="classesChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Paiements récents</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Montant</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT e.nom, e.prenom, p.montant, p.date_paiement FROM paiements p JOIN eleves e ON p.eleve_id = e.id ORDER BY p.date_paiement DESC LIMIT 5");
                            while ($row = $stmt->fetch()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nom'] . ' ' . $row['prenom']); ?></td>
                                    <td><?php echo number_format($row['montant'], 2); ?> €</td>
                                    <td><?php echo date('d/m/Y', strtotime($row['date_paiement'])); ?></td>
                                </tr>
                            <?php endwhile;
                        } catch (PDOException $e) {
                            echo '<tr><td colspan="3">Erreur de chargement</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des classes
    const ctx = document.getElementById('classesChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['6ème', '5ème', 'Autres'],
            datasets: [{
                data: [<?php echo $stats['eleves']; ?>, 0, 0], // À adapter avec données réelles
                backgroundColor: ['#007bff', '#28a745', '#ffc107']
            }]
        }
    });
</script>

<?php include '../includes/footer.php'; ?>