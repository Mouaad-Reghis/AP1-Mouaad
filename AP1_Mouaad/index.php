<?php
include("_conf.php");
//on se connecte à MySQL
if($connexion = mysqli_connect($server, $user, $pwd, $bdd))
{
    //Si la connexion est réussi
    echo 'Félicitation, vous êtes connecté à la BDD';

    //on oublie  pas de fermer la connexion
    mysqli_close($connexion);
}

else //Mais si elle rate
{
    echo 'Erreur'; //On affiche un message d'erreur
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<link rel="stylesheet" href="style.css">
<body>
    <h2>Connexion</h2>
    <form method="post" action="login.php">
        <label>Email :</label>
        <input type="email" name="email" required><br>
        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Se connecter">
    </form>
    <a href="oublie_mdp.php">Mot de passe oublié ?</a>
    <a href="inscription.php">Créer un compte</a>
</body>
</html>