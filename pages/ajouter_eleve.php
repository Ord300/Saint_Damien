<?php
// pages/ajouter_eleve.php - Ajouter un élève
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Ajouter un élève';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = trim($_POST['matricule'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $postnom = trim($_POST['postnom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $sexe = $_POST['sexe'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $adresse = trim($_POST['adresse'] ?? '');
    $parent = trim($_POST['parent'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $classe_id = $_POST['classe_id'] ?? '';
    $option_id = $_POST['option_id'] ?? '';

    // Validation
    if (empty($matricule) || empty($nom) || empty($prenom) || empty($sexe) || empty($date_naissance)) {
        $errors[] = 'Veuillez remplir tous les champs obligatoires.';
    }

    if (!empty($telephone) && !preg_match('/^[0-9+\-\s()]+$/', $telephone)) {
        $errors[] = 'Numéro de téléphone invalide.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO eleves (matricule, nom, postnom, prenom, sexe, date_naissance, adresse, parent, telephone, classe_id, option_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$matricule, $nom, $postnom, $prenom, $sexe, $date_naissance, $adresse, $parent, $telephone, $classe_id ?: null, $option_id ?: null]);
            $success = 'Élève ajouté avec succès.';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = 'Le matricule existe déjà.';
            } else {
                $errors[] = 'Erreur lors de l\'ajout de l\'élève.';
            }
        }
    }
}

// Récupérer les classes et options
try {
    $classes = $pdo->query("SELECT * FROM classes ORDER BY nom")->fetchAll();
    $options = $pdo->query("SELECT * FROM options ORDER BY nom")->fetchAll();
} catch (PDOException $e) {
    $classes = [];
    $options = [];
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4>Ajouter un élève</h4>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="matricule" class="form-label">Matricule *</label>
                                <input type="text" class="form-control" id="matricule" name="matricule" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom *</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="postnom" class="form-label">Postnom</label>
                                <input type="text" class="form-control" id="postnom" name="postnom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom *</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sexe" class="form-label">Sexe *</label>
                                <select class="form-control" id="sexe" name="sexe" required>
                                    <option value="">Sélectionner</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_naissance" class="form-label">Date de naissance *</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control" id="adresse" name="adresse" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="parent" class="form-label">Parent/Tuteur</label>
                                <input type="text" class="form-control" id="parent" name="parent">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" name="telephone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="classe_id" class="form-label">Classe</label>
                                <select class="form-control" id="classe_id" name="classe_id">
                                    <option value="">Sélectionner une classe</option>
                                    <?php foreach ($classes as $classe): ?>
                                        <option value="<?php echo $classe['id']; ?>"><?php echo htmlspecialchars($classe['nom']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option_id" class="form-label">Option</label>
                                <select class="form-control" id="option_id" name="option_id">
                                    <option value="">Sélectionner une option</option>
                                    <?php foreach ($options as $option): ?>
                                        <option value="<?php echo $option['id']; ?>"><?php echo htmlspecialchars($option['nom']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_eleves.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter l'élève</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>