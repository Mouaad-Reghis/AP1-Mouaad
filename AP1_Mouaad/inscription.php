<?php
include("_conf.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connexion = mysqli_connect($server, $user, $pwd, $bdd);

    if ($connexion) {
        $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
        $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
        $email = mysqli_real_escape_string($connexion, $_POST['email']);
        $login = mysqli_real_escape_string($connexion, $_POST['login']);
        $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

        $requete = "INSERT INTO utilisateur (nom, prenom, email, login, motdepasse) 
                    VALUES ('$nom', '$prenom', '$email', '$login', '$motdepasse')";

        if (mysqli_query($connexion, $requete)) {
            echo '<p class="message succes">Inscription réussie ! Vous pouvez maintenant vous connecter.</p>';
        } else {
            echo '<p class="message erreur">Erreur : ' . mysqli_error($connexion) . '</p>';
        }

        mysqli_close($connexion);
    } else {
        die('Erreur de connexion : ' . mysqli_connect_error());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Inscription</h1>
    <form method="post" action="inscription.php">
        <label>Nom :</label><br>
        <input type="text" name="nom" required><br><br>

        <label>Prénom :</label><br>
        <input type="text" name="prenom" required><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label>Nom d'utilisateur :</label><br>
        <input type="text" name="login" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="motdepasse" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>
    <div class="links">
        <a href="index.php">Retour à la connexion</a>
    </div>
</div>
</body>
</html>