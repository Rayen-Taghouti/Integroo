<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: login_signup.php");
    exit();
}
$profile_pic = 'Images/default_profile.jpg';
if (isset($_SESSION['user_id'])) {
    $conn = new mysqli('localhost', 'root', '', 'integroo');
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (!empty($user['profile_pic']) && file_exists($user['profile_pic'])) {
                $profile_pic = $user['profile_pic'];
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/icon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="dashbord_employee.css?v=<?= time(); ?>">
    <title>Integroo</title>
</head>

<body>
    <section id="sidebar">
        <a href="#dashboard" class="brand active">INTEGROO</a>
        <ul class="side_menu">
            <li><a href="#" class="active" data-section="dashboard"><i class='bx bxs-dashboard icon'></i>Tableau de bord</a></li>
            <li class="divider" data-text="main">Principale</li>
            <li>
                <a href="#"><i class='bx bxs-inbox icon'></i>Mes Eléments<i class='bx bx-chevron-right icon_right'></i></a>
                <ul class="side_dropdown">
                    <li><a href="#" data-section="parcours">Mon Parcours</a></li>
                    <li><a href="#" data-section="quiz">Mes Quiz</a></li>
                    <li><a href="#" data-section="messagerie">Messagerie</a></li>
                </ul>
            </li>
            <li><a href="#" data-section="profil"><i class='bx bxs-user icon'></i>Mon Profil</a></li>
            <li><a href="#" data-section="faq"><i class='bx bx-help-circle icon'></i>Aide / FAQ</a></li>
        </ul>
        <div class="ads">
            <div class="wrapper">
                <a href="#" class="btn-ia">Assistant IA</a>
                <p>Posez votre question à <span>l'IA</span>.</p>
            </div>
        </div>
    </section>
    <section id="content">
        <nav>
            <i class='bx bx-menu toggle_sidebar'></i>
            <form action="#">
                <div class="from_group">
                    <input type="text" placeholder="Recherche...">
                    <i class='bx bx-search icon'></i>
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
            <div class="prophile">
                <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="prophile picture">
                <ul class="profile_link">
                    <li><a href="#"><i class='bx bxs-user-circle icon'></i>Profil</a></li>
                    <li><a href="#"><i class='bx bxs-cog icon'></i>Paramètres</a></li>
                    <li><a href="logout.php"><i class='bx bxs-log-out-circle icon'></i>Déconnexion</a></li>
                </ul>
            </div>
        </nav>
        <main id="dashboard" class="main-section active">
            <div class="info_data">
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>0</h2>
                            <p>Tâches à faire</p>
                        </div>
                        <i class='bx bx-task-x icon'></i>
                    </div>
                    <span class="progress" data-value="50%"></span>
                    <span class="label">50%</span>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>0</h2>
                            <p>Tâches terminées</p>
                        </div>
                        <i class='bx bx-task icon down'></i>
                    </div>
                    <span class="progress" data-value="40%"></span>
                    <span class="label">40%</span>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>0</h2>
                            <p>Quiz en attente</p>
                        </div>
                        <i class='bx bx-time bx-task icon'></i>
                    </div>
                    <span class="progress" data-value="70%"></span>
                    <span class="label">70%</span>
                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>0</h2>
                            <p>Messages non lus</p>
                        </div>
                        <i class='bx bx-message-rounded-dots icon'></i>
                    </div>
                    <span class="progress" data-value="10%"></span>
                    <span class="label">10%</span>
                </div>
            </div>
            <div class="data">
                <div class="content_data">
                    <div class="head">
                        <h3>Documents récents / à lire</h3>
                        <div class="menu">
                            <i class='bx bx-dots-horizontal-rounded icon'></i>
                            <ul class="menu_link">
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
                                <td>Date</td>
                                <td>Télécharger</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Contrat de travail</td>
                                <td class="status-unread">À lire</td>
                                <td>12/03/2025</td>
                                <td><i class='bx bx-download icon'></i></td>
                            </tr>
                            <tr>
                                <td>Guide d'intégration RH</td>
                                <td class="status-read">Lu</td>
                                <td>10/03/2025</td>
                                <td><i class='bx bx-download icon'></i></td>
                            </tr>
                            <tr>
                                <td>Politique de confidentialité</td>
                                <td class="status-signed">Signé</td>
                                <td>09/03/2025</td>
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
                            <ul class="menu_link">
                                <li><a href="#" data-section="messagerie">Plus de détails</a></li>
                                <li><a href="#">Sauvegarder</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat_box" id="chat_box"></div>
                    <form action="#">
                        <div class="form_groupe">
                            <input type="hidden" id="sender-id" value="1">
                            <input type="hidden" id="receiver-id" value="2">
                            <input type="text" id="chat-input" placeholder="Taper...">
                            <button type="submit" class="btn_send"><i class='bx bx-send'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <main id="parcours" class="main-section">
            <h1 class="title" data-section="parcours">Mon Parcours</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Page d'accueil</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active" data-section="parcours">Mon Parcours</a></li>
            </ul>
            <p>Voici votre parcours personnalisé.</p>
        </main>
        <main id="quiz" class="main-section">
            <h1 class="title" data-section="quiz">Mes Quiz</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Page d'accueil</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active" data-section="quiz">Mes Quiz</a></li>
            </ul>
            <p>Testez vos connaissances avec nos Quiz.</p>
        </main>
        <main id="messagerie" class="main-section" class="messagerie">
            <div class="container">
                <div class="leftSide">
                    <div class="header">
                        <div class="userImage">
                            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="prophile picture" class="cover">
                        </div>
                        <ul class="nav-icons">
                            <li><ion-icon name="scan-circle-outline"></ion-icon></li>
                            <li><ion-icon name="chatbubble-outline"></ion-icon></li>
                            <li><ion-icon name="ellipsis-vertical-outline"></ion-icon></li>
                        </ul>
                    </div>
                    <div class="search-chat">
                        <div>
                            <input type="text" placeholder="Rechercher une conversation">
                            <ion-icon name="search-outline"></ion-icon>
                        </div>
                    </div>
                    <div class="chatlist"></div>
                </div>
                <div class="rightSide">
                    <div class="header">
                        <div class="imgText" id="currentChatHeader">
                            <div class="userImage">
                                <img src="Images/profile_rh.jpg" alt="profile image" class="cover">
                            </div>
                            <h4>Sonia Dahmen <br><span>en ligne</span></h4>
                        </div>
                        <ul class="nav-icons">
                            <li><ion-icon name="ellipsis-vertical-outline"></ion-icon></li>
                        </ul>
                    </div>
                    <div class="chatbox"></div>
                    <div class="chat-input">
                        <ion-icon name="happy-outline" id="emojiButton"></ion-icon>
                        <input type="text" placeholder="Taper un message" id="messageInput">
                        <ion-icon name="mic-outline"></ion-icon>
                        <div class="emoji-picker" id="emojiPicker">
                            <div class="emoji-category">Smileys</div>
                            <div class="emoji-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <main id="profil" class="main-section">
            <h1 class="title" data-section="profil">Mon Profil</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Page d'accueil</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active" data-section="profil">Mon Profil</a></li>
            </ul>
            <p>Gérez vos informations personnelles.</p>
        </main>
        <main id="faq" class="main-section">
            <h1 class="title" data-section="faq">Aide / FAQ</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Page d'accueil</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active" data-section="faq">Aide / FAQ</a></li>
            </ul>
            <p>Retrouvez vos réponses ici.</p>
        </main>
    </section>
    <script src="dashbord_employee.js?v=<?= time(); ?>"></script>
    <script src="messagerie.js?v=<?= time(); ?>"></script>
    <script src="dashboard_chat.js?v=<?= time(); ?>"></script>
    <script>
        const CURRENT_USER_ID = <?php echo $_SESSION['user_id']; ?>;
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</html>