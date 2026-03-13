<?php
// pages/ajouter_utilisateur.php - Ajouter un utilisateur
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Ajouter un utilisateur';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validation
    if (empty($nom) || empty($email) || empty($mot_de_passe) || empty($role)) {
        $errors[] = 'Veuillez remplir tous les champs.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse email invalide.';
    }

    if (strlen($mot_de_passe) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    }

    if (empty($errors)) {
        try {
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $hashed_password, $role]);
            $success = 'Utilisateur ajouté avec succès.';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = 'Cet email existe déjà.';
            } else {
                $errors[] = 'Erreur lors de l\'ajout de l\'utilisateur.';
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
                <h4>Ajouter un utilisateur</h4>
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
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe *</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle *</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin">Administrateur</option>
                            <option value="enseignant">Enseignant</option>
                            <option value="secretaire">Secrétaire</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_utilisateurs.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter l'utilisateur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>