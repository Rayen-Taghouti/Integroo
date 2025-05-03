<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/icon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="login_signup.css?v=<?= time(); ?>">
    <title>Integroo</title>
</head>

<body>
    <div class="container">
        <div class="form_box login">
            <form action="connecter.php" method="POST">
                <h1>Se Connecter</h1>
                <div class="input_box">
                    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input_box">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot_link">
                    <a href="#">Mot de passe oublié?</a>
                </div>
                <button type="submit" class="btn">Se Connecter</button>
            </form>
        </div>
        <div class="form_box register">
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <h1>Inscription</h1>
                <div class="input_box">
                    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input_box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input_box">
                    <input type="text" name="cin" placeholder="CIN" required>
                    <i class='bx bx-id-card'></i>
                </div>
                <div class="input_box">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
                    <i class='bx bxs-camera'></i>
                </div>
                <div class="input_box">
                    <select name="role" required>
                        <option value="" disabled selected>Choisissez votre rôle</option>
                        <option value="boss">Boss</option>
                        <option value="rh_manager">RH Manager</option>
                        <option value="employee">Employee</option>
                    </select>
                    <i class='bx bx-user-check'></i>
                </div>
                <button type="submit" class="btn">Inscription</button>
            </form>
        </div>
        <div class="toggle_box">
            <div class="toggle_panel togle_left">
                <h1>Bonjour, Bienvenue</h1>
                <p>Vous n'avez pas de compte?</p>
                <button class="btn register-btn">Inscription</button>
            </div>
            <div class="toggle_panel togle_right">
                <h1>Content de te revoir!</h1>
                <p>Vous avez déjà un compte?</p>
                <button class="btn login-btn">Se Connecter</button>
            </div>
        </div>
    </div>
    <div class="toast">
        <div class="toast_contant">
            <i class="fas fa-solid fa-check check"></i>
            <div class="message">
                <span class="text text_1">Demande envoyée avec succès</span>
                <span class="text text_2">Votre demande a été bien transmise au RH Manager. Veuillez patienter, un e-mail vous sera envoyé contenant votre mot de passe.</span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress"></div>
    </div>
    <script src="login_signup.js?v=<?= time(); ?>"></script>
</body>

</html>