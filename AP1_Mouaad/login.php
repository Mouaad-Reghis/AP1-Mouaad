<?php
session_start();
include "_conf.php";

// Déconnexion
if (isset($_POST['send_deco'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Connexion (seulement si la session n’existe pas déjà)
if (!isset($_SESSION['Sid']) && isset($_POST['send_con'])) {
    $login = $_POST['login'];
    $mdp = md5($_POST['motdepasse']); // Le champ doit s’appeler 'motdepasse' dans index.php

    $requete = "SELECT * FROM utilisateur WHERE login='$login' AND motdepasse='$mdp'";
    $resultat = mysqli_query($connexion, $requete);

    if ($donnees = mysqli_fetch_assoc($resultat)) {
        $_SESSION['Sid'] = $donnees['num'];
        $_SESSION['Slogin'] = $donnees['login'];
        $_SESSION['Sprenom'] = $donnees['prenom'];
        $_SESSION['Stype'] = $donnees['type'];
    } else {
        echo "Login ou mot de passe incorrect";
        exit();
    }
}

// Si l’utilisateur n’est pas connecté, rediriger vers l’index
if (!isset($_SESSION['Sid'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1 style="text-align:center;">Accueil</h1>
    <p style="text-align:center;">Partie <?= ($_SESSION['Stype']) ?></p>

    <div class="welcome-section">
        <h2>Bienvenue <?= ($_SESSION['Sprenom']) ?></h2>
    </div>

    <div class="card-container">
        <div class="card">
            <a href="liste_comptes_rendus.php">Liste compte rendus</a>
            <p>Voir la liste des comptes rendus de l’élève</p>
        </div>
        <div class="card">
            <a href="creer_modifier.php">Créer un compte rendu</a>
            <p>Créer un nouveau compte rendu</p>
        </div>
        <div class="card">
            <a href="commentaires.php">Commentaires</a>
            <p>Voir les commentaires reçus</p>
        </div>
        <div class="card">
            <a href="perso.php">Page personnelle</a>
            <p>Accédez à votre page personnelle.</p>
        </div>
    </div>

    <br><br>
    <form method="post" action="accueil.php">
        <input type="submit" value="Se déconnecter" name="send_deco">
    </form>
</div>

</body>
</html>