<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Gestion Scolaire'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Sidebar -->
                <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Menu</span>
                        </h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/dashboard.php">
                                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/liste_eleves.php">
                                    <i class="fas fa-users"></i> Élèves
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/liste_classes.php">
                                    <i class="fas fa-school"></i> Classes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/liste_options.php">
                                    <i class="fas fa-list"></i> Options
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/liste_enseignants.php">
                                    <i class="fas fa-chalkboard-teacher"></i> Enseignants
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/liste_paiements.php">
                                    <i class="fas fa-money-bill-wave"></i> Paiements
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/liste_notes.php">
                                    <i class="fas fa-graduation-cap"></i> Notes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/liste_utilisateurs.php">
                                    <i class="fas fa-user-cog"></i> Utilisateurs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../logout.php">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            <?php endif; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo isset($page_title) ? $page_title : 'Gestion Scolaire'; ?></h1>
                </div>