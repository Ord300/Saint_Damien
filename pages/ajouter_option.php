<?php
// pages/ajouter_option.php - Ajouter une option
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Ajouter une option';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validation
    if (empty($nom)) {
        $errors[] = 'Veuillez saisir le nom de l\'option.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO options (nom, description) VALUES (?, ?)");
            $stmt->execute([$nom, $description]);
            $success = 'Option ajoutée avec succès.';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = 'Cette option existe déjà.';
            } else {
                $errors[] = 'Erreur lors de l\'ajout de l\'option.';
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
                <h4>Ajouter une option</h4>
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
                        <label for="nom" class="form-label">Nom de l'option *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_options.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter l'option</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>