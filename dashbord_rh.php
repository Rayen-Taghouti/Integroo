<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'rh_manager') {
    header("Location: login_signup.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/icon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="dashbord_rh.css?v=<?= time(); ?>">
    <title>Integroo</title>
</head>

<body>
    <section id="sidebar">
        <a href="#" class="brand">INTEGROO</a>
        <ul class="side_menu">
            <li><a href="#" class="active"><i class='bx bxs-dashboard icon'></i> Tableau de bord</a></li>
            <li class="divider" data-text="main">Principale</li>
            <li>
                <a href="#"><i class='bx bxs-inbox icon'></i> Éléments <i class='bx bx-chevron-right icon_right'></i></a>
                <ul class="side_dropdown">
                    <li><a href="#">Employés</a></li>
                    <li><a href="#">Parcours d'onboarding</a></li>
                    <li><a href="#">Tâches / Missions</a></li>
                    <li><a href="#">Quizz & Évaluations</a></li>
                </ul>
            </li>
            <li><a href="#"><i class='bx bx-file-blank icon'></i> Documents RH</a></li>
            <li><a href="#"><i class='bx bx-message-rounded-detail icon'></i> Messages</a></li>
            <li class="divider" data-text="paramètres">Paramètres</li>
            <li><a href="#"><i class='bx bx-line-chart icon'></i> Rapports & Statistiques</a></li>
            <li>
                <a href="#"><i class='bx bx-cog icon'></i> Paramètres <i class='bx bx-chevron-right icon_right'></i></a>
                <ul class="side_dropdown">
                    <li><a href="#">Aide / FAQ</a></li>
                    <li><a href="#">Paramètres du compte</a></li>
                </ul>
            </li>
        </ul>
        <div class="ads">
            <div class="wrapper">
                <a href="#" class="ia">Assistant IA</a>
                <p>Posez votre question à <span>l'IA</span>.</p>
            </div>
        </div>
    </section>
    <section id="content">
        <nav>
            <i class='bx bx-menu toggle_sidebar'></i>
            <form action="#">
                <div class="form_group">
                    <input type="text" placeholder="Recherche...">
                    <i class='bx bx-search-alt-2 icon'></i>
                </div>
            </form>
            <a href="#" class="nav_link">
                <i class='bx bxs-bell icon'></i>
                <span class="badge">5</span>
            </a>
            <a href="#" class="nav_link">
                <i class='bx bxs-message-square-dots icon'></i>
                <span class="badge">8</span>
            </a>
            <span class="divider"></span>
            <div class="profile">
                <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="profile image">
                <ul class="profile_link">
                    <li><a href="#"><i class='bx bxs-user-circle icon'></i> Profil</a></li>
                    <li><a href="#"><i class='bx bxs-cog icon'></i> Paramètres</a></li>
                    <li><a href="logout.php"><i class='bx bxs-log-out-circle icon'></i> Déconnexion</a></li>
                </ul>
            </div>
        </nav>
        <main>
            <h1 class="title">Tableau de bord</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Page d'accueil</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Tableau de bord</a></li>
            </ul>
            <div class="info_data">
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>4</h2>
                            <p>Parcours actifs</p>
                        </div>
                        <i class='bx bx-task icon green'></i>
                    </div>
                    <span class="progress" data-value="50%"></span>
                    <span class="label">50%</span>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>2</h2>
                            <p>Tâches complétées</p>
                        </div>
                        <i class='bx bx-check-circle icon green'></i>
                    </div>
                    <span class="progress" data-value="30%"></span>
                    <span class="label">30%</span>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>5</h2>
                            <p>Quizs en cours</p>
                        </div>
                        <i class='bx bx-time bx-edit-alt icon'></i>
                    </div>
                    <span class="progress" data-value="60%"></span>
                    <span class="label">60%</span>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>2</h2>
                            <p>Messages non lus</p>
                        </div>
                        <i class='bx bx-envelope icon'></i>
                    </div>
                    <span class="progress" data-value="10%"></span>
                    <span class="label">10%</span>
                </div>
            </div>
            <div class="data">
                <div class="content_data">
                    <div class="head">
                        <h3>Documents récemment ajoutés</h3>
                        <div class="menu">
                            <i class='bx bx-dots-horizontal-rounded icon'></i>
                            <ul class="menu_links">
                                <li><a href="#">Plus de détails</a></li>
                                <li><a href="#">Sauvegarder</a></li>
                            </ul>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Nom du document</td>
                                <td>Statut</td>
                                <td>Envoyer_à</td>
                                <td>Télécharger</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Contrat de travail</td>
                                <td class="status-unread">À lire</td>
                                <td><a href="#" class="envoyer_a">Rayen Taghouti</a></td>
                                <td><i class='bx bx-download icon'></i></td>
                            </tr>
                            <tr>
                                <td>Guide d'intégration RH</td>
                                <td class="status-read">Lu</td>
                                <td><a href="#" class="envoyer_a">Rayen Taghouti</a></td>
                                <td><i class='bx bx-download icon'></i></td>
                            </tr>
                            <tr>
                                <td>Politique de confidentialité</td>
                                <td class="status-signed">Signé</td>
                                <td><a href="#" class="envoyer_a">Rayen Taghouti</a></td>
                                <td><i class='bx bx-download icon'></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="content_data">
                    <div class="head">
                        <h3>Boîte de discussion</h3>
                        <div class="menu">
                            <i class='bx bx-dots-horizontal-rounded icon'></i>
                            <ul class="menu_links">
                                <li><a href="#">Plus de détails</a></li>
                                <li><a href="#">Sauvegarder</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat_box">
                        <p class="day"><span>Aujourd'hui</span></p>
                        <div class="msg me">
                            <div class="chat">
                                <div class="profile">
                                    <span class="time">18:30</span>
                                </div>
                                <p>Bonjour</p>
                            </div>
                        </div>
                        <div class="msg">
                            <img src="Images/profile_pic.JPG" alt="profile image">
                            <div class="chat">
                                <div class="profile">
                                    <span class="username">Rayen Taghouti</span>
                                    <span class="time">18:30</span>
                                </div>
                                <p>Bonjour, tout va bien !!</p>
                            </div>
                        </div>
                        <div class="msg me">
                            <div class="chat">
                                <div class="profile">
                                    <span class="time">18:30</span>
                                </div>
                                <p>Oui cv, tu a une nouvelle documents.</p>
                            </div>
                        </div>
                        <div class="msg">
                            <img src="Images/profile_pic.JPG" alt="profile image">
                            <div class="chat">
                                <div class="profile">
                                    <span class="username">Rayen Taghouti</span>
                                    <span class="time">18:30</span>
                                </div>
                                <p>Ok, merci.</p>
                            </div>
                        </div>
                    </div>
                    <form action="#">
                        <div class="form_group">
                            <input type="text" placeholder="Taper...">
                            <button type="submit" class="btn_send"><i class='bx bx-send'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </section>
    <script src="dashbord_rh.js?v=<?= time(); ?>"></script>
</body>

</html>