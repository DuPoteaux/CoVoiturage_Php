  <?php
    include 'Connexion.php';
    
    $request="UPDATE edition SET AnnéeEdition='".$_POST["Annee"]."',DateDebut='".$_POST["DateDebut"]."',HeureDebut='".$_POST["HeureDebut"]."',DateFin='".$_POST["DateFin"]."',HeureFin='".$_POST["HeureFin"]."',Lieu='".$_POST["Lieu"]."',Description='".$_POST["Description"]."' WHERE AnnéeEdition='".$_POST["IdEdition"]."'";
    //requete pour modifier l'édition en fonction des informations fournies
    
    if ($conn->query($request) === TRUE){
        ?>
        <script type="text/javascript">
            alert("Ton édition a bien été modifiée");
            location="gestionEdition.php";
        </script>
      <?php
      die();          //notification du succès ou de l'échec de la requête
    } else {
        ?>
        <script type="text/javascript">
            alert("Une erreur s'est produite réessaye");
            location="gestionEdition.php";
        </script>
      <?php
      die();
    }

?>