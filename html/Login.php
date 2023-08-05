<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate">
    <title>LBR Covoiturage</title>
    <!--Favicon-->
	<link rel="icon" href="../images/LBR Ressources/intiniales.png" type="images/png"/> 
    <!-- CSS only -->
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
          rel="stylesheet">
    <!-- importer le fichier de style -->
    <link rel="stylesheet" href="../css/login.css" media="screen" type="text/css"/>
</head>
<body>
<div id="container">
    <!-- zone de connexion -->

    <form action="LoginAction.php" method="POST">

      
        <h1>Connexion</h1>
        <label><b>Email</b>
            <input type="text" placeholder="Email" name="email" value="rolanddebotho19@gmail.com">
        </label>

        <label><b>Mot de passe</b>
            <input type="password" placeholder="Mot de passe" name="password"  value="Property18">
        </label>
        <small><a href="forget_password.php" style="text-decoration: none;">Tu as oublié ton mot de passe ?</a></small>

        <input style="border-radius: 100px;" type="submit" id='submit' value='Se connecter'>
        <?php
        if (isset($_GET['erreur'])) {
            $err = $_GET['erreur'];
            if ($err == 1 || $err == 2)
                echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
        }
        ?>
        <h4 class="separator"><span>OU</span></h4>
        <button type="button" class="google-btn">Se connecter avec Google</button>
        <div>
            <p style="text-align: center;">Tu n'as pas encore de compte ? <a href="register.php" style="text-decoration: none;">Inscris-toi !</a></p>
        </div>
    </form>
</div>
</body>
</html>
