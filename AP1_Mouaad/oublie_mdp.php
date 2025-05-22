<?php
if (isset($_POST['email'])) {
    $mail = $_POST['email'];
    echo "Le formulaire a été envoyé avec comme email : " . $mail;
    
    include("_conf.php");

    // Connexion à MySQL avec mysqli
    $connexion = mysqli_connect($server, $user, $pwd, $bdd);

    if ($connexion) {
        echo 'Félicitation, vous êtes connecté à la BDD<br>';

        // Requête pour vérifier si l'email existe
        $requete = "SELECT * FROM utilisateur WHERE email='" . mysqli_real_escape_string($connexion, $mail) . "'";
        $resultat = mysqli_query($connexion, $requete);

        $login = 0;

        while ($donnees = mysqli_fetch_assoc($resultat)) {
            $login = $donnees['login']; 
        }

        
        if ($login != 0) {
            echo "Email trouvé<br>";
            
            
            $nouveau_mdp = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
            $mdp_crypte = md5($nouveau_mdp);

            $update = "UPDATE utilisateur SET motdepasse = '$mdp_crypte' WHERE email = '" . mysqli_real_escape_string($connexion, $mail) . "'";
            if (mysqli_query($connexion, $update)) {
                echo "Mot de passe temporaire mis à jour<br>";

                
                $message = "Bonjour,\n\nVoici votre nouveau mot de passe temporaire pour vous connecter : $nouveau_mdp\n\nPensez à le modifier après connexion.";
                mail($mail, 'Mot de passe réinitialisé - Site BTS SIO SLAM', $message);
                echo "Un mot de passe temporaire a été envoyé à votre adresse email.";
            } else {
                echo "Erreur lors de la mise à jour du mot de passe.";
            }
        } else {
            echo "Email non présent";
        }

        mysqli_close($connexion);
    } else {
        echo 'Erreur lors de la connexion à la BDD';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mot de passe oublié</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Récupération de mot de passe</h2>
    <form method="post" action="oublie_mdp.php">
        <label>Email :</label>
        <input type="email" name="email" required><br>
        <input type="submit" value="Confirmer">
    </form>
</body>
</html>
