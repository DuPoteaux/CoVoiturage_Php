<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Merci d'avoir rejoint la plateforme </title>
</head>
<body>

<?php
if (isset($_POST["reg_user"]) && $_POST["email"]) {
    include('Connexion.php');
    $request = mysqli_query($conn, "SELECT * FROM compte WHERE Email = '" . $_POST["email"] . "'");
    $row = mysqli_num_rows($request);

    if ($row < 1) {
        $token = md5($_POST["email"]);
        $password = $_POST["password_1"];
        $password = password_hash($password, PASSWORD_DEFAULT);     //on cripte le mot de passe
        $tel = $_POST['phone'];
        if (isset($_POST["VerifAdmin"]) && $_POST["VerifAdmin"] == 1) {
            $verifadmin = 1;
        } else {
            $verifadmin = 0;
        }
        //mail
        $path = 'localhost/ProjetCovoiturage/html/verify_email.php?key=' . $_POST['email'] . '&token=' . $token;
        $request = mysqli_query($conn, "INSERT INTO compte(Nom,Prenom, Email, telephone, motDePasse, isAdmin,DateCreation, lien_verif_mail) VALUES ('" . $_POST["nom"] . "','" . $_POST["prenom"] . "','" . $_POST["email"] . "','" . $tel . "','" . $password . "','" . $verifadmin . "','" . date("Y.m.d") . "', '" . $token . "')");
        $link = "<a href='localhost/ProjetCovoiturage/html/verify_email.php?key=" . $_POST['email'] . "&token=" . $token . "' target='_blank' style='font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #000000; display: inline-block;'>Confirme ton compte</a>";
        $lienBrut = "<a href='localhost/ProjetCovoiturage/html/verify_email.php?key=" . $_POST['email'] . "&token=" . $token . "' target='_blank' style='color: #FFA73B;'>" . $path . "</a>";

        include('../mails/header_mails.php');

        $dest = $_POST['email'];
        $sujet = "Merci d'avoir rejoint la plateforme !";
        $corp = file_get_contents("../mails/template_mail_confirmation_mail.php");

        $variables = array(
            "{{Prenom}}" => $_POST['prenom'],
            "{{Bouton}}" => $link,
            "{{Lien}}" => $lienBrut
        );

        foreach ($variables as $key => $value) {
            $corp = str_replace($key, $value, $corp);
        }

        if (mail($dest, $sujet, $corp, $headers)) {
            $_SESSION['alertMailEnvoye'] = 1;
            header("Location:home.php");
        }
    else {
        echo "<script type='text/javascript'>alert('Le mail ne s\'est pas envoyé');</script>";              //L'utilisateur est notifié selon le succès ou l'échec des requetes et de l'envoi du mail
        ?>
        <script>document.location.href = '../html/home.php';</script>
    <?php
    }
    }
    else{
    echo "<script type='text/javascript'>alert('Oups, il semble que tu aies déjà créé un compte. Vérifie ta boîte mail et confirme ton compte.');</script>";
    ?>
        <script>document.location.href = '../html/home.php';</script>
        <?php
    }
}

?>

</body>
</html>