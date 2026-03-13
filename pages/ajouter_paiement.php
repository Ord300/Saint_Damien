<?php
// pages/ajouter_paiement.php - Ajouter un paiement
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Ajouter un paiement';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eleve_id = $_POST['eleve_id'] ?? '';
    $montant = $_POST['montant'] ?? '';
    $type_frais = trim($_POST['type_frais'] ?? '');
    $date_paiement = $_POST['date_paiement'] ?? '';

    // Validation
    if (empty($eleve_id) || empty($montant) || empty($type_frais) || empty($date_paiement)) {
        $errors[] = 'Veuillez remplir tous les champs.';
    }

    if (!is_numeric($montant) || $montant <= 0) {
        $errors[] = 'Le montant doit être un nombre positif.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO paiements (eleve_id, montant, type_frais, date_paiement) VALUES (?, ?, ?, ?)");
            $stmt->execute([$eleve_id, $montant, $type_frais, $date_paiement]);
            $success = 'Paiement ajouté avec succès.';
        } catch (PDOException $e) {
            $errors[] = 'Erreur lors de l\'ajout du paiement.';
        }
    }
}

// Récupérer les élèves
try {
    $eleves = $pdo->query("SELECT id, CONCAT(nom, ' ', prenom) as nom_complet FROM eleves ORDER BY nom")->fetchAll();
} catch (PDOException $e) {
    $eleves = [];
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Ajouter un paiement</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="eleve_id" class="form-label">Élève *</label>
                        <select class="form-control" id="eleve_id" name="eleve_id" required>
                            <option value="">Sélectionner un élève</option>
                            <?php foreach ($eleves as $eleve): ?>
                                <option value="<?php echo $eleve['id']; ?>"><?php echo htmlspecialchars($eleve['nom_complet']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant *</label>
                        <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
                    </div>
                    <div class="mb-3">
                        <label for="type_frais" class="form-label">Type de frais *</label>
                        <select class="form-control" id="type_frais" name="type_frais" required>
                            <option value="">Sélectionner</option>
                            <option value="Inscription">Inscription</option>
                            <option value="Mensualité">Mensualité</option>
                            <option value="Matériel">Matériel</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_paiement" class="form-label">Date de paiement *</label>
                        <input type="date" class="form-control" id="date_paiement" name="date_paiement" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_paiements.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter le paiement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>