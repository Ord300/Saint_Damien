<?php
// pages/ajouter_enseignant.php - Ajouter un enseignant
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Ajouter un enseignant';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $cours = trim($_POST['cours'] ?? '');
    $classe_id = $_POST['classe_id'] ?? '';

    // Validation
    if (empty($nom)) {
        $errors[] = 'Veuillez saisir le nom de l\'enseignant.';
    }

    if (!empty($telephone) && !preg_match('/^[0-9+\-\s()]+$/', $telephone)) {
        $errors[] = 'Numéro de téléphone invalide.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO enseignants (nom, telephone, cours, classe_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $telephone, $cours, $classe_id ?: null]);
            $success = 'Enseignant ajouté avec succès.';
        } catch (PDOException $e) {
            $errors[] = 'Erreur lors de l\'ajout de l\'enseignant.';
        }
    }
}

// Récupérer les classes
try {
    $classes = $pdo->query("SELECT * FROM classes ORDER BY nom")->fetchAll();
} catch (PDOException $e) {
    $classes = [];
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Ajouter un enseignant</h4>
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
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone">
                    </div>
                    <div class="mb-3">
                        <label for="cours" class="form-label">Cours</label>
                        <input type="text" class="form-control" id="cours" name="cours">
                    </div>
                    <div class="mb-3">
                        <label for="classe_id" class="form-label">Classe</label>
                        <select class="form-control" id="classe_id" name="classe_id">
                            <option value="">Sélectionner une classe</option>
                            <?php foreach ($classes as $classe): ?>
                                <option value="<?php echo $classe['id']; ?>"><?php echo htmlspecialchars($classe['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_enseignants.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter l'enseignant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>