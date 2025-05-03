<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/icon.png">
    <script src="https://unpkg.com/scrollreveal"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=arrow_forward" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="index.css?v=<?= time(); ?>">
    <title>Integroo</title>
</head>

<body>
    <nav>
        <div class="nav_bar">
            <div class="nav_logo"><a href="#">INTEGROO</a></div>
            <ul class="nav_links">
                <li class="link"><a href="#">Solutions</a></li>
                <li class="link"><a href="#">Caractéristiques</a></li>
                <li class="link"><a href="#">Ressources</a></li>
            </ul>
            <div class="nav_btns">
                <a href="login_signup.php"><button class="btn btn_primary">Se connecter</button></a>
                <a href="login_signup.php?form=register"><button class="btn btn_secondary">Demander un compte</button></a>
            </div>
        </div>
    </nav>
    <header class="header">
        <div class="header_container">
            <div class="header_content">
                <h1>Dès l'intégration, automatisez vos processus RH et boostez l'expérience collaborateur</h1>
                <p>
                    Votre croissance compte — explorez un cheminement de carrière personnalisé et restez connecté avec le bon soutien à chaque étape
                </p>
                <div class="header_btns">
                    <a href="login_signup.php?form=register"><button class="btn btn_secondary">S'inscrire</button></a>
                    <a href="login_signup.php"><button class="btn btn_primary">Accéder à mon espace</button></a>
                </div>
            </div>
            <div class="header_image">
                <img src="Images/logo-r.png" alt="header" />
            </div>
        </div>
    </header>
    <section class="section_container about_container" id="about">
        <div class="about_image">
            <img src="Images/ooredoo.jpg" alt="about">
        </div>
        <div class="about_content">
            <h3>À propos de nous</h3>
            <h2 class="section_header">
                La solution d'onboarding pensée pour Ooredoo Tunisie
            </h2>
            <p class="section_subhedear">
                Integroo digitalise le parcours d'intégration des collaborateurs en offrant une expérience fluide, personnalisée et engageante, de l'arrivée jusqu'à l'épanouissement professionnel.
            </p>
            <div class="about_grid">
                <div class="about_card">
                    <h4>Collaborateurs onboardés</h4>
                    <p>+200</p>
                </div>
                <div class="about_card">
                    <h4>Gain de temps RH</h4>
                    <p>+50%</p>
                </div>
                <div class="about_card">
                    <h4>Satisfaction employés</h4>
                    <p>98%</p>
                </div>
            </div>
        </div>
    </section>
    <section class="container_cards">
        <div class="container swiper">
            <div class="card_wrapper">
                <ul class="card_list swiper-wrapper">
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/workflows.webp" alt="Imgae of the workflow" class="card_image">
                            <p class="badge">Intégration Automatisée</p>
                            <h2 class="card_title">Accélérez l'intégration des employés grâce à des flux de travail personnalisés.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/Knowledge.png" alt="Imgae of the Brain" class="card_image">
                            <p class="badge">Centre de Connaissances</p>
                            <h2 class="card_title">Matériel de formation centralisé, politiques et outils internes pour un accès rapide.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/messages.jpg" alt="Imgae of the messages" class="card_image">
                            <p class="badge">Communication Personnalisée</p>
                            <h2 class="card_title">Envoyez des messages ciblés, des rappels et des contrôles à chaque employé.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/Progress.jpg" alt="Imgae of the progress" class="card_image">
                            <p class="badge">Suivi des Progrès en Temps Réel</p>
                            <h2 class="card_title">Surveillez les étapes d'intégration et l'engagement dans un seul tableau de bord.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/task.png" alt="Imgae of the tasks" class="card_image">
                            <p class="badge">Gestion des Tâches</p>
                            <h2 class="card_title">Attribuez, suivez et vérifiez les tâches, de la signature des documents.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/SmartScheduling.png" alt="Imgae of the scheduling" class="card_image">
                            <p class="badge">Planification Intelligente</p>
                            <h2 class="card_title">Synchronisez les sessions d'intégration, les réunions et les délais sans effort.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/rh.png" alt="Imgae of the RH" class="card_image">
                            <p class="badge">RH sans Papier</p>
                            <h2 class="card_title">Numérisez les contrats, les politiques et les formulaires avec des signatures intégrées.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                    <li class="card_item swiper-slide">
                        <a href="#" class="card_link">
                            <img src="Images/Sup.png" alt="Imgae of the supports" class="card_image">
                            <p class="badge">Accès Multi-appareils</p>
                            <h2 class="card_title">Prise en charge de l'accès aux ordinateurs de bureau, aux appareils mobiles et tablettes.</h2>
                            <button class="card_button material-symbols-rounded">arrow_forward</button>
                        </a>
                    </li>
                </ul>
                <div class="swiper-pagination"></div>
                <div class="swiper-slide-button swiper-button-prev"></div>
                <div class="swiper-slide-button swiper-button-next"></div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="section_container footer_container">
            <div class="footer_cal">
                <h4>INTEGROO</h4>
                <p>© 2025 Integroo - Propulsé pour Ooredoo Tunisie | Simplifiez l'intégration, optimisez l'expérience collaborateur.</p>
                <div class="footer_socials">
                    <span>
                        <a href="#"><i class="ri-global-fill"></i></a>
                    </span>
                </div>
            </div>
            <div class="footer_cal">
                <h4>informations sur l'entreprise</h4>
                <a href="#home">Page d'accueil</a>
                <a href="#">Solutions</a>
                <a href="#">Caractéristiques</a>
                <a href="">Ressources</a>
            </div>
            <div class="footer_cal">
                <h4>Contact</h4>
                <a href="#">
                    <span><i class="ri-mail-line"></i></span> rtrayen4@gmail.com
                </a>
                <a href="#">
                    <span><i class="ri-phone-line"></i></span> +216 58113275
                </a>
            </div>
        </div>
        <div class="footer_bar">
            &copy; 2025 Integroo. Tous droits réservés par Rayen Taghouti.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="index.js?v=<?= time(); ?>"></script>
</body>

</html>