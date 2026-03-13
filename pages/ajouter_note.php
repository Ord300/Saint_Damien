<?php
// pages/ajouter_note.php - Ajouter une note
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/db.php';
$page_title = 'Ajouter une note';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eleve_id = $_POST['eleve_id'] ?? '';
    $cours_id = $_POST['cours_id'] ?? '';
    $note = $_POST['note'] ?? '';
    $date_evaluation = $_POST['date_evaluation'] ?? '';

    // Validation
    if (empty($eleve_id) || empty($cours_id) || empty($note) || empty($date_evaluation)) {
        $errors[] = 'Veuillez remplir tous les champs.';
    }

    if (!is_numeric($note) || $note < 0 || $note > 20) {
        $errors[] = 'La note doit être comprise entre 0 et 20.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO notes (eleve_id, cours_id, note, date_evaluation) VALUES (?, ?, ?, ?)");
            $stmt->execute([$eleve_id, $cours_id, $note, $date_evaluation]);
            $success = 'Note ajoutée avec succès.';
        } catch (PDOException $e) {
            $errors[] = 'Erreur lors de l\'ajout de la note.';
        }
    }
}

// Récupérer les élèves et cours
try {
    $eleves = $pdo->query("SELECT id, CONCAT(nom, ' ', prenom) as nom_complet FROM eleves ORDER BY nom")->fetchAll();
    $cours = $pdo->query("SELECT * FROM cours ORDER BY nom")->fetchAll();
} catch (PDOException $e) {
    $eleves = [];
    $cours = [];
}

include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Ajouter une note</h4>
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
                        <label for="cours_id" class="form-label">Cours *</label>
                        <select class="form-control" id="cours_id" name="cours_id" required>
                            <option value="">Sélectionner un cours</option>
                            <?php foreach ($cours as $cour): ?>
                                <option value="<?php echo $cour['id']; ?>"><?php echo htmlspecialchars($cour['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note (0-20) *</label>
                        <input type="number" step="0.25" min="0" max="20" class="form-control" id="note" name="note" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_evaluation" class="form-label">Date d'évaluation *</label>
                        <input type="date" class="form-control" id="date_evaluation" name="date_evaluation" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="liste_notes.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter la note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>