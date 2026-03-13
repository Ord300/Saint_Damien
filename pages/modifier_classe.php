<?php
// pages/modifier_classe.php - Modifier une classe
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Modifier une classe';

$id = $_GET['id'] ?? 0;
$errors = [];
$success = '';

if (!$id) {
    header('Location: liste_classes.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
    $stmt->execute([$id]);
    $classe = $stmt->fetch();

    if (!$classe) {
        header('Location: liste_classes.php');
        exit;
    }
} catch (PDOException $e) {
    header('Location: liste_classes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $niveau = trim($_POST['niveau'] ?? '');

    if (empty($nom) || empty($niveau)) {
        $errors[] = 'Veuillez remplir tous les champs.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE classes SET nom = ?, niveau = ? WHERE id = ?");
            $stmt->execute([$nom, $niveau, $id]);
            $success = 'Classe modifiée avec succès.';
            $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
            $stmt->execute([$id]);
            $classe = $stmt->fetch();
        } catch (PDOException $e) {
            $errors[] = 'Erreur lors de la modification de la classe.';
        }
    }
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Modifier une classe</h4>
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
                        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($classe['nom']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="niveau" class="form-label">Niveau *</label>
                        <select class="form-control" id="niveau" name="niveau" required>
                            <option value="">Sélectionner un niveau</option>
                            <option value="Primaire" <?php echo $classe['niveau'] === 'Primaire' ? 'selected' : ''; ?>>Primaire</option>
                            <option value="Secondaire" <?php echo $classe['niveau'] === 'Secondaire' ? 'selected' : ''; ?>>Secondaire</option>
                            <option value="Lycée" <?php echo $classe['niveau'] === 'Lycée' ? 'selected' : ''; ?>>Lycée</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_classes.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Modifier la classe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>