<?php
// pages/modifier_option.php - Modifier une option
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Modifier une option';

$id = $_GET['id'] ?? 0;
$errors = [];
$success = '';

if (!$id) {
    header('Location: liste_options.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM options WHERE id = ?");
    $stmt->execute([$id]);
    $option = $stmt->fetch();

    if (!$option) {
        header('Location: liste_options.php');
        exit;
    }
} catch (PDOException $e) {
    header('Location: liste_options.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($nom)) {
        $errors[] = 'Veuillez saisir le nom de l\'option.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE options SET nom = ?, description = ? WHERE id = ?");
            $stmt->execute([$nom, $description, $id]);
            $success = 'Option modifiée avec succès.';
            $stmt = $pdo->prepare("SELECT * FROM options WHERE id = ?");
            $stmt->execute([$id]);
            $option = $stmt->fetch();
        } catch (PDOException $e) {
            $errors[] = 'Erreur lors de la modification de l\'option.';
        }
    }
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Modifier une option</h4>
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
                        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($option['nom']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($option['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_options.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Modifier l'option</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>