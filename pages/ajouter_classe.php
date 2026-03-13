<?php
// pages/ajouter_classe.php - Ajouter une classe
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Ajouter une classe';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $niveau = trim($_POST['niveau'] ?? '');

    // Validation
    if (empty($nom) || empty($niveau)) {
        $errors[] = 'Veuillez remplir tous les champs.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO classes (nom, niveau) VALUES (?, ?)");
            $stmt->execute([$nom, $niveau]);
            $success = 'Classe ajoutée avec succès.';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = 'Cette classe existe déjà.';
            } else {
                $errors[] = 'Erreur lors de l\'ajout de la classe.';
            }
        }
    }
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Ajouter une classe</h4>
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
                        <label for="nom" class="form-label">Nom de la classe *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="niveau" class="form-label">Niveau *</label>
                        <select class="form-control" id="niveau" name="niveau" required>
                            <option value="">Sélectionner un niveau</option>
                            <option value="Primaire">Primaire</option>
                            <option value="Secondaire">Secondaire</option>
                            <option value="Lycée">Lycée</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_classes.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter la classe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>