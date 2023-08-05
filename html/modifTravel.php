<!DOCTYPE html>
<html>
<head>
    <title>Modification d'un trajet conducteur</title>
    <!--CSS Files-->
    <link href ="../css/profile.css" rel="stylesheet" >
    <link href="../css/EditTrajet.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Favicon-->
	
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Library-->
    <script src="https://code.jquery.com/jquery-1.6.4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!--Google Maps API-->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzOGPYwZqOFb6hCGtZo68-nQ4sxwum7Hg">
    </script>
</head>

<body>
<?php 
include 'Connexion.php';        //Connexion a la base de donnée
include 'NavbarConn.php';       //Affichage navbar
if(!isset($_SESSION["login"]) || $_SESSION["login"] == 0){
    header("location:Login.php");
}

if(isset($_SESSION["mail"])){
    $idTrajet=$_POST["IdTrajet"];
    $requete = "SELECT * FROM trajet WHERE IdTrajet='".$idTrajet."'";       //On récupère les informations nécessaires depuis la base de données a partir de l'id du trajet récupéré
			$result = mysqli_query($conn,$requete);
            $row = mysqli_fetch_assoc($result);
            $isDemande= $row["isDemande"];
            $TypeTrajet=$row["TypeTrajet"];
            $Description=$row["Description"];
            $LieuDepart=$row["LieuDepart"];
            $AdresseDepart=$row["AdresseDepart"];
            $lngdep=$row["LongitudeDepart"];
            $latdep=$row["LatitudeDepart"];
            $LieuArrivee=$row["LieuArrivee"];
            $AdresseArrivee=$row["AdresseArrivee"];
            $lngarr=$row["LongitudeArrivee"];
            $latarr=$row["LatitudeArrivee"];
            $DateDepart=$row["DateDepart"];
            $DateArrivee=$row["DateArrivee"];
            $HeureDepart=$row["HeureDepart"];
            $HeureArrivee=$row["HeureArrivee"];
            $Prix=$row["Prix"];
            $tel=$row["DisplayTel"];
            $NbPass=$row["NbPassagers"];
            $idCompte=$row["IdCompte"];
            $placesRestantes=$row['PlacesRestantes'];
    ?>

<!--Affichage du trajet sous la forme de carte pour donner a l'utilisateur une idée de l'apparence de sa demande une fois modifiée-->
<div id="Historique" >
    <div class="ListeTrajets">
    <div id="down" class="wrapper">
			<?php
                //Affichage des horaires
				$hourString1 = substr($HeureDepart,0,2);
				$hourString2 = substr($HeureDepart,3,2);
				$hourStringDeparture = $hourString1."h".$hourString2;


				$hourString3 = substr($HeureArrivee,0,2);
				$hourString4 = substr($HeureArrivee,3,2);
				$hourStringArrival = $hourString3."h".$hourString4;

				?>
                    <!--Affichage de la date et du lieu de départ ainsi que la destination-->
					<div class="item">
						<div class="data-group">
							<span class="horaire" id="heureDepart">
								<?php echo $hourStringDeparture; ?>
							</span>
							<span class="place" id="lieuDepart">
								<?php echo ($LieuDepart); ?>
							</span>

							<span class="date" id="dateDepart">
								<?php echo ($DateDepart); ?>
							</span>
						</div>

						<div class="data-group" >
							<span class="horaire" id="heureArrivee">
								<?php echo $hourStringArrival; ?>
							</span>
							<span class="place" id="lieuArrivee">
								<?php echo ($LieuArrivee); ?>
							</span>
                            <!--Affichage du prix-->
							<span class="price" id="prix">
								<?php echo $row['Prix']; ?>€
							</span>
						</div>
                        <!--On récupère les informations du créateur du trajet-->
						<div class="account-info">
						<?php $sql = "SELECT * FROM compte WHERE IdCompte='".$idCompte."'";
                                
								$resultat = mysqli_query($conn,$sql); 
								$row2 = mysqli_fetch_assoc($resultat);?>
							<img class="profile-picture" src="../images/PhotoProfil/<?php if($row2["PhotoProfil"]!=NULL){echo $row2["PhotoProfil"];}else{echo "defaultpp.jpg";} ?>">
							<div class="profile-info">
                                
								<span class="name"><?php echo $row2["Prenom"] ?></span>
								<div class="available" id="placesRestantes">
									<?php
										if($placesRestantes == 1) echo $placesRestantes." place restante";
										else echo $placesRestantes." places restantes"
									?>
								</div>
                                <!--On affiche le numéro de téléphone si l'utilisateur le souhaite-->
                                <div class="available" id="placesRestantes">
                                    <span id="DisplayTel">
									<?php
										if($row["DisplayTel"]==1)echo "numéro de téléphone: 0".$row2["telephone"];
		
									?>
                                    </span>
								</div>
							</div>				
						</div>
					</div>
			</div>
    	</div>
    </div>

    <?php
        if($isDemande==0){
    ?>
    <div class="infos formDiv" id="infos" >
        <!--Formulaire pour la modification d'un trajet-->
        <form action="modifTravelAction.php" method="post" class="infos-secondary">
            <!--On stocke less coordonnées s'il s'agit d'un aller ou d'un retour et s'il s'agit ou non d'une demande ici-->
            <input type="hidden" name="long" id="long2" value="<?php if($TypeTrajet=="Aller"){echo $lngdep;}else{echo $lngarr;}?>">
            <input type="hidden" name="lat" id="lat2" value="<?php if($TypeTrajet=="Aller"){echo $latdep;}else{echo $latarr;}?>">
            <input type="hidden" name="isDemande" value="0">
            <input type="hidden" name="AllerRetour" value="<?php echo $TypeTrajet; ?>">
            
            <!--Groupe contenant les informations en lien avec des emplacement-->
            <div class="input-group">
                <div class="form-item"><label for="departure2" id="departureSpan2" class="upper">Ville de départ/arrivée:</label>   <input type="text" class="inputUpper" required="required" name="Ville" id="departure2" value="<?php echo $LieuDepart; ?>"></div>
                <div class="form-item"><label for="adresse2" id="adresseSpan2" class="upper">Adresse de départ/arrivée:</label>   <input type="text" class="inputUpper" required="required" name="Adresse" id="adresse2"  value="<?php echo $AdresseDepart; ?>"></div>
                <div class="form-item"><label for="arrival2" id="arrivalSpan2" class="upper">Vers</label>   <input type="text" required="required" class="inputUpper" name="arrival" id="arrival2"  value="<?php echo $LieuArrivee; ?>"></div>
            </div>
            <!--Groupe contenant la date et l'heure de départ-->
            <div class="input-group">
                <div class="form-item datediv">
                    <label for="date2" class="upper">Date de départ:</label>
                    <input type="date" class="inputUpper" id="date2" required="required" name="Date-de-Depart" class="Date-de-Depart" min="2022-09-16" value="<?php echo $DateDepart; ?>" >
                </div>
                <div class="timediv">
                    <label for="heureDepart2" class="labeltime">Heure de départ:</label>
                    <select name="time" id="heureDepart2" class="selecttime">
                        <option value="00:00" <?php if(substr_replace($HeureDepart ,"", -8)=="00:00"){echo 'selected="selected"';} ?>>00:00</option><option value="00:10" <?php if(substr_replace($HeureDepart ,"", -8)=="00:10"){echo 'selected="selected"';} ?>>00:10</option><option value="00:20" <?php if(substr_replace($HeureDepart ,"", -8)=="00:20"){echo 'selected="selected"';} ?>>00:20</option><option value="00:30" <?php if(substr_replace($HeureDepart ,"", -8)=="00:30"){echo 'selected="selected"';} ?>>00:30</option><option value="00:40" <?php if(substr_replace($HeureDepart ,"", -8)=="00:40"){echo 'selected="selected"';} ?>>00:40</option><option value="00:50" <?php if(substr_replace($HeureDepart ,"", -8)=="00:50"){echo 'selected="selected"';} ?>>00:50</option><option value="01:00" <?php if(substr_replace($HeureDepart ,"", -8)=="01:00"){echo 'selected="selected"';} ?>>01:00</option><option value="01:10" <?php if(substr_replace($HeureDepart ,"", -8)=="01:10"){echo 'selected="selected"';} ?>>01:10</option><option value="01:20" <?php if(substr_replace($HeureDepart ,"", -8)=="01:20"){echo 'selected="selected"';} ?>>01:20</option><option value="01:30" <?php if(substr_replace($HeureDepart ,"", -8)=="01:30"){echo 'selected="selected"';} ?>>01:30</option><option value="01:40" <?php if(substr_replace($HeureDepart ,"", -8)=="01:40"){echo 'selected="selected"';} ?>>01:40</option><option value="01:50" <?php if(substr_replace($HeureDepart ,"", -8)=="01:50"){echo 'selected="selected"';} ?>>01:50</option><option value="02:00" <?php if(substr_replace($HeureDepart ,"", -8)=="02:00"){echo 'selected="selected"';} ?>>02:00</option><option value="02:10" <?php if(substr_replace($HeureDepart ,"", -8)=="02:10"){echo 'selected="selected"';} ?>>02:10</option><option value="02:20" <?php if(substr_replace($HeureDepart ,"", -8)=="02:20"){echo 'selected="selected"';} ?>>02:20</option><option value="02:30" <?php if(substr_replace($HeureDepart ,"", -8)=="02:30"){echo 'selected="selected"';} ?>>02:30</option><option value="02:40" <?php if(substr_replace($HeureDepart ,"", -8)=="02:40"){echo 'selected="selected"';} ?>>02:40</option><option value="02:50" <?php if(substr_replace($HeureDepart ,"", -8)=="02:50"){echo 'selected="selected"';} ?>>02:50</option><option value="03:00" <?php if(substr_replace($HeureDepart ,"", -8)=="03:00"){echo 'selected="selected"';} ?>>03:00</option><option value="03:10" <?php if(substr_replace($HeureDepart ,"", -8)=="03:10"){echo 'selected="selected"';} ?>>03:10</option><option value="03:20" <?php if(substr_replace($HeureDepart ,"", -8)=="03:20"){echo 'selected="selected"';} ?>>03:20</option><option value="03:30" <?php if(substr_replace($HeureDepart ,"", -8)=="03:30"){echo 'selected="selected"';} ?>>03:30</option><option value="03:40" <?php if(substr_replace($HeureDepart ,"", -8)=="03:40"){echo 'selected="selected"';} ?>>03:40</option><option value="03:50" <?php if(substr_replace($HeureDepart ,"", -8)=="03:50"){echo 'selected="selected"';} ?>>03:50</option><option value="04:00" <?php if(substr_replace($HeureDepart ,"", -8)=="04:00"){echo 'selected="selected"';} ?>>04:00</option><option value="04:10" <?php if(substr_replace($HeureDepart ,"", -8)=="04:10"){echo 'selected="selected"';} ?>>04:10</option><option value="04:20" <?php if(substr_replace($HeureDepart ,"", -8)=="04:20"){echo 'selected="selected"';} ?>>04:20</option><option value="04:30" <?php if(substr_replace($HeureDepart ,"", -8)=="04:30"){echo 'selected="selected"';} ?>>04:30</option><option value="04:40" <?php if(substr_replace($HeureDepart ,"", -8)=="04:40"){echo 'selected="selected"';} ?>>04:40</option><option value="04:50" <?php if(substr_replace($HeureDepart ,"", -8)=="04:50"){echo 'selected="selected"';} ?>>04:50</option><option value="05:00" <?php if(substr_replace($HeureDepart ,"", -8)=="05:00"){echo 'selected="selected"';} ?>>05:00</option><option value="05:10" <?php if(substr_replace($HeureDepart ,"", -8)=="05:10"){echo 'selected="selected"';} ?>>05:10</option><option value="05:20" <?php if(substr_replace($HeureDepart ,"", -8)=="05:20"){echo 'selected="selected"';} ?>>05:20</option><option value="05:30" <?php if(substr_replace($HeureDepart ,"", -8)=="05:30"){echo 'selected="selected"';} ?>>05:30</option><option value="05:40" <?php if(substr_replace($HeureDepart ,"", -8)=="05:40"){echo 'selected="selected"';} ?>>05:40</option><option value="05:50" <?php if(substr_replace($HeureDepart ,"", -8)=="05:50"){echo 'selected="selected"';} ?>>05:50</option><option value="06:00" <?php if(substr_replace($HeureDepart ,"", -8)=="06:00"){echo 'selected="selected"';} ?>>06:00</option><option value="06:10" <?php if(substr_replace($HeureDepart ,"", -8)=="06:10"){echo 'selected="selected"';} ?>>06:10</option><option value="06:20" <?php if(substr_replace($HeureDepart ,"", -8)=="06:20"){echo 'selected="selected"';} ?>>06:20</option><option value="06:30" <?php if(substr_replace($HeureDepart ,"", -8)=="06:30"){echo 'selected="selected"';} ?>>06:30</option><option value="06:40" <?php if(substr_replace($HeureDepart ,"", -8)=="06:40"){echo 'selected="selected"';} ?>>06:40</option><option value="06:50" <?php if(substr_replace($HeureDepart ,"", -8)=="06:50"){echo 'selected="selected"';} ?>>06:50</option><option value="07:00" <?php if(substr_replace($HeureDepart ,"", -8)=="07:00"){echo 'selected="selected"';} ?>>07:00</option><option value="07:10" <?php if(substr_replace($HeureDepart ,"", -8)=="07:10"){echo 'selected="selected"';} ?>>07:10</option><option value="07:20" <?php if(substr_replace($HeureDepart ,"", -8)=="07:20"){echo 'selected="selected"';} ?>>07:20</option><option value="07:30" <?php if(substr_replace($HeureDepart ,"", -8)=="07:30"){echo 'selected="selected"';} ?>>07:30</option><option value="07:40" <?php if(substr_replace($HeureDepart ,"", -8)=="07:40"){echo 'selected="selected"';} ?>>07:40</option><option value="07:50" <?php if(substr_replace($HeureDepart ,"", -8)=="07:50"){echo 'selected="selected"';} ?>>07:50</option><option value="08:00" <?php if(substr_replace($HeureDepart ,"", -8)=="08:00"){echo 'selected="selected"';} ?>>08:00</option><option value="08:10" <?php if(substr_replace($HeureDepart ,"", -8)=="08:10"){echo 'selected="selected"';} ?>>08:10</option><option value="08:20" <?php if(substr_replace($HeureDepart ,"", -8)=="08:20"){echo 'selected="selected"';} ?>>08:20</option><option value="08:30" <?php if(substr_replace($HeureDepart ,"", -8)=="08:30"){echo 'selected="selected"';} ?>>08:30</option><option value="08:40" <?php if(substr_replace($HeureDepart ,"", -8)=="08:40"){echo 'selected="selected"';} ?>>08:40</option><option value="08:50" <?php if(substr_replace($HeureDepart ,"", -8)=="08:50"){echo 'selected="selected"';} ?>>08:50</option><option value="09:00" <?php if(substr_replace($HeureDepart ,"", -8)=="09:00"){echo 'selected="selected"';} ?>>09:00</option><option value="09:10" <?php if(substr_replace($HeureDepart ,"", -8)=="09:10"){echo 'selected="selected"';} ?>>09:10</option><option value="09:20" <?php if(substr_replace($HeureDepart ,"", -8)=="09:20"){echo 'selected="selected"';} ?>>09:20</option><option value="09:30" <?php if(substr_replace($HeureDepart ,"", -8)=="09:30"){echo 'selected="selected"';} ?>>09:30</option><option value="09:40" <?php if(substr_replace($HeureDepart ,"", -8)=="09:40"){echo 'selected="selected"';} ?>>09:40</option><option value="09:50" <?php if(substr_replace($HeureDepart ,"", -8)=="09:50"){echo 'selected="selected"';} ?>>09:50</option><option value="10:00" <?php if(substr_replace($HeureDepart ,"", -8)=="10:00"){echo 'selected="selected"';} ?>>10:00</option><option value="10:10" <?php if(substr_replace($HeureDepart ,"", -8)=="10:10"){echo 'selected="selected"';} ?>>10:10</option><option value="10:20" <?php if(substr_replace($HeureDepart ,"", -8)=="10:20"){echo 'selected="selected"';} ?>>10:20</option><option value="10:30" <?php if(substr_replace($HeureDepart ,"", -8)=="10:30"){echo 'selected="selected"';} ?>>10:30</option><option value="10:40" <?php if(substr_replace($HeureDepart ,"", -8)=="10:40"){echo 'selected="selected"';} ?>>10:40</option><option value="10:50" <?php if(substr_replace($HeureDepart ,"", -8)=="10:50"){echo 'selected="selected"';} ?>>10:50</option><option value="11:00" <?php if(substr_replace($HeureDepart ,"", -8)=="11:00"){echo 'selected="selected"';} ?>>11:00</option><option value="11:10" <?php if(substr_replace($HeureDepart ,"", -8)=="11:10"){echo 'selected="selected"';} ?>>11:10</option><option value="11:20" <?php if(substr_replace($HeureDepart ,"", -8)=="11:20"){echo 'selected="selected"';} ?>>11:20</option><option value="11:30" <?php if(substr_replace($HeureDepart ,"", -8)=="11:30"){echo 'selected="selected"';} ?>>11:30</option><option value="11:40" <?php if(substr_replace($HeureDepart ,"", -8)=="11:40"){echo 'selected="selected"';} ?>>11:40</option><option value="11:50" <?php if(substr_replace($HeureDepart ,"", -8)=="11:50"){echo 'selected="selected"';} ?>>11:50</option>
                        <option value="12:00" <?php if(substr_replace($HeureDepart ,"", -8)=="12:00"){echo 'selected="selected"';} ?>>12:00</option><option value="12:10" <?php if(substr_replace($HeureDepart ,"", -8)=="12:10"){echo 'selected="selected"';} ?>>12:10</option><option value="12:20" <?php if(substr_replace($HeureDepart ,"", -8)=="12:20"){echo 'selected="selected"';} ?>>12:20</option><option value="12:30" <?php if(substr_replace($HeureDepart ,"", -8)=="12:30"){echo 'selected="selected"';} ?>>12:30</option><option value="12:40" <?php if(substr_replace($HeureDepart ,"", -8)=="12:40"){echo 'selected="selected"';} ?>>12:40</option><option value="12:50" <?php if(substr_replace($HeureDepart ,"", -8)=="12:50"){echo 'selected="selected"';} ?>>12:50</option><option value="13:00" <?php if(substr_replace($HeureDepart ,"", -8)=="13:00"){echo 'selected="selected"';} ?>>13:00</option><option value="13:10" <?php if(substr_replace($HeureDepart ,"", -8)=="13:10"){echo 'selected="selected"';} ?>>13:10</option><option value="13:20" <?php if(substr_replace($HeureDepart ,"", -8)=="13:20"){echo 'selected="selected"';} ?>>13:20</option><option value="13:30" <?php if(substr_replace($HeureDepart ,"", -8)=="13:30"){echo 'selected="selected"';} ?>>13:30</option><option value="13:40" <?php if(substr_replace($HeureDepart ,"", -8)=="13:40"){echo 'selected="selected"';} ?>>13:40</option><option value="13:50" <?php if(substr_replace($HeureDepart ,"", -8)=="13:50"){echo 'selected="selected"';} ?>>13:50</option><option value="14:00" <?php if(substr_replace($HeureDepart ,"", -8)=="14:00"){echo 'selected="selected"';} ?>>14:00</option><option value="14:10" <?php if(substr_replace($HeureDepart ,"", -8)=="14:10"){echo 'selected="selected"';} ?>>14:10</option><option value="14:20" <?php if(substr_replace($HeureDepart ,"", -8)=="14:20"){echo 'selected="selected"';} ?>>14:20</option><option value="14:30" <?php if(substr_replace($HeureDepart ,"", -8)=="14:30"){echo 'selected="selected"';} ?>>14:30</option><option value="14:40" <?php if(substr_replace($HeureDepart ,"", -8)=="14:40"){echo 'selected="selected"';} ?>>14:40</option><option value="14:50" <?php if(substr_replace($HeureDepart ,"", -8)=="14:50"){echo 'selected="selected"';} ?>>14:50</option><option value="15:00" <?php if(substr_replace($HeureDepart ,"", -8)=="15:00"){echo 'selected="selected"';} ?>>15:00</option><option value="15:10" <?php if(substr_replace($HeureDepart ,"", -8)=="15:10"){echo 'selected="selected"';} ?>>15:10</option><option value="15:20" <?php if(substr_replace($HeureDepart ,"", -8)=="15:20"){echo 'selected="selected"';} ?>>15:20</option><option value="15:30" <?php if(substr_replace($HeureDepart ,"", -8)=="15:30"){echo 'selected="selected"';} ?>>15:30</option><option value="15:40" <?php if(substr_replace($HeureDepart ,"", -8)=="15:40"){echo 'selected="selected"';} ?>>15:40</option><option value="15:50" <?php if(substr_replace($HeureDepart ,"", -8)=="15:50"){echo 'selected="selected"';} ?>>15:50</option><option value="16:00" <?php if(substr_replace($HeureDepart ,"", -8)=="16:00"){echo 'selected="selected"';} ?>>16:00</option><option value="16:10" <?php if(substr_replace($HeureDepart ,"", -8)=="16:10"){echo 'selected="selected"';} ?>>16:10</option><option value="16:20" <?php if(substr_replace($HeureDepart ,"", -8)=="16:20"){echo 'selected="selected"';} ?>>16:20</option><option value="16:30" <?php if(substr_replace($HeureDepart ,"", -8)=="16:30"){echo 'selected="selected"';} ?>>16:30</option><option value="16:40" <?php if(substr_replace($HeureDepart ,"", -8)=="16:40"){echo 'selected="selected"';} ?>>16:40</option><option value="16:50" <?php if(substr_replace($HeureDepart ,"", -8)=="16:50"){echo 'selected="selected"';} ?>>16:50</option><option value="17:00" <?php if(substr_replace($HeureDepart ,"", -8)=="17:00"){echo 'selected="selected"';} ?>>17:00</option><option value="17:10" <?php if(substr_replace($HeureDepart ,"", -8)=="17:10"){echo 'selected="selected"';} ?>>17:10</option><option value="17:20" <?php if(substr_replace($HeureDepart ,"", -8)=="17:20"){echo 'selected="selected"';} ?>>17:20</option><option value="17:30" <?php if(substr_replace($HeureDepart ,"", -8)=="17:30"){echo 'selected="selected"';} ?>>17:30</option><option value="17:40" <?php if(substr_replace($HeureDepart ,"", -8)=="17:40"){echo 'selected="selected"';} ?>>17:40</option><option value="17:50" <?php if(substr_replace($HeureDepart ,"", -8)=="17:50"){echo 'selected="selected"';} ?>>17:50</option><option value="18:00" <?php if(substr_replace($HeureDepart ,"", -8)=="18:00"){echo 'selected="selected"';} ?>>18:00</option><option value="18:10" <?php if(substr_replace($HeureDepart ,"", -8)=="18:10"){echo 'selected="selected"';} ?>>18:10</option><option value="18:20" <?php if(substr_replace($HeureDepart ,"", -8)=="18:20"){echo 'selected="selected"';} ?>>18:20</option><option value="18:30" <?php if(substr_replace($HeureDepart ,"", -8)=="18:30"){echo 'selected="selected"';} ?>>18:30</option><option value="18:40" <?php if(substr_replace($HeureDepart ,"", -8)=="18:40"){echo 'selected="selected"';} ?>>18:40</option><option value="18:50" <?php if(substr_replace($HeureDepart ,"", -8)=="18:50"){echo 'selected="selected"';} ?>>18:50</option><option value="19:00" <?php if(substr_replace($HeureDepart ,"", -8)=="19:00"){echo 'selected="selected"';} ?>>19:00</option><option value="19:10" <?php if(substr_replace($HeureDepart ,"", -8)=="19:10"){echo 'selected="selected"';} ?>>19:10</option><option value="19:20" <?php if(substr_replace($HeureDepart ,"", -8)=="19:20"){echo 'selected="selected"';} ?>>19:20</option><option value="19:30" <?php if(substr_replace($HeureDepart ,"", -8)=="19:30"){echo 'selected="selected"';} ?>>19:30</option><option value="19:40" <?php if(substr_replace($HeureDepart ,"", -8)=="19:40"){echo 'selected="selected"';} ?>>19:40</option><option value="19:50" <?php if(substr_replace($HeureDepart ,"", -8)=="19:50"){echo 'selected="selected"';} ?>>19:50</option><option value="20:00" <?php if(substr_replace($HeureDepart ,"", -8)=="20:00"){echo 'selected="selected"';} ?>>20:00</option><option value="20:10" <?php if(substr_replace($HeureDepart ,"", -8)=="20:10"){echo 'selected="selected"';} ?>>20:10</option><option value="20:20" <?php if(substr_replace($HeureDepart ,"", -8)=="20:20"){echo 'selected="selected"';} ?>>20:20</option><option value="20:30" <?php if(substr_replace($HeureDepart ,"", -8)=="20:30"){echo 'selected="selected"';} ?>>20:30</option><option value="20:40" <?php if(substr_replace($HeureDepart ,"", -8)=="20:40"){echo 'selected="selected"';} ?>>20:40</option><option value="20:50" <?php if(substr_replace($HeureDepart ,"", -8)=="20:50"){echo 'selected="selected"';} ?>>20:50</option><option value="21:00" <?php if(substr_replace($HeureDepart ,"", -8)=="21:00"){echo 'selected="selected"';} ?>>21:00</option><option value="21:10" <?php if(substr_replace($HeureDepart ,"", -8)=="21:10"){echo 'selected="selected"';} ?>>21:10</option><option value="21:20" <?php if(substr_replace($HeureDepart ,"", -8)=="21:20"){echo 'selected="selected"';} ?>>21:20</option><option value="21:30" <?php if(substr_replace($HeureDepart ,"", -8)=="21:30"){echo 'selected="selected"';} ?>>21:30</option><option value="21:40" <?php if(substr_replace($HeureDepart ,"", -8)=="21:40"){echo 'selected="selected"';} ?>>21:40</option><option value="21:50" <?php if(substr_replace($HeureDepart ,"", -8)=="21:50"){echo 'selected="selected"';} ?>>21:50</option><option value="22:00" <?php if(substr_replace($HeureDepart ,"", -8)=="22:00"){echo 'selected="selected"';} ?>>22:00</option><option value="22:10" <?php if(substr_replace($HeureDepart ,"", -8)=="22:10"){echo 'selected="selected"';} ?>>22:10</option><option value="22:20" <?php if(substr_replace($HeureDepart ,"", -8)=="22:20"){echo 'selected="selected"';} ?>>22:20</option><option value="22:30" <?php if(substr_replace($HeureDepart ,"", -8)=="22:30"){echo 'selected="selected"';} ?>>22:30</option><option value="22:40" <?php if(substr_replace($HeureDepart ,"", -8)=="22:40"){echo 'selected="selected"';} ?>>22:40</option><option value="22:50" <?php if(substr_replace($HeureDepart ,"", -8)=="22:50"){echo 'selected="selected"';} ?>>22:50</option><option value="23:00" <?php if(substr_replace($HeureDepart ,"", -8)=="23:00"){echo 'selected="selected"';} ?>>23:00</option><option value="23:10" <?php if(substr_replace($HeureDepart ,"", -8)=="23:10"){echo 'selected="selected"';} ?>>23:10</option><option value="23:20" <?php if(substr_replace($HeureDepart ,"", -8)=="23:20"){echo 'selected="selected"';} ?>>23:20</option><option value="23:30" <?php if(substr_replace($HeureDepart ,"", -8)=="23:30"){echo 'selected="selected"';} ?>>23:30</option><option value="23:40" <?php if(substr_replace($HeureDepart ,"", -8)=="23:40"){echo 'selected="selected"';} ?>>23:40</option><option value="23:50" <?php if(substr_replace($HeureDepart ,"", -8)=="23:50"){echo 'selected="selected"';} ?>>23:50</option>
                    </select>
                </div>
            </div>
            <div class="form-item">
                <label id="arrivalHour2" class="arrivalHour"> Heure d'arrivée estimée: <?php echo substr_replace($HeureArrivee ,"", -8); ?></label>
            </div>
            <input type="hidden" name="heureArrivee" id="heureArrivee2" value="<?php echo substr_replace($HeureArrivee ,"", -8); ?>">
            <input type="hidden" name="dateArr" id="dateArr2" value="<?php echo $DateArrivee; ?>">
            <br/>
            <!--Groupe contenant le prix-->
            <div class="input-group PassPrix">
                <div class="form-item">
                    <label for="Prix" class="upper">Prix par passager: </label>
                    <div>
                        <input type="number" class="inputUpper" required="required"  name="Prix" id ="Prix" step="1" min="0" value="<?php echo $Prix; ?>">
                        <i class="PrixSelect">€</i>
                    </div>
                </div>
            </div>
            <br/>
            <div class="input-group">
                <div class="form-item">
                    <label for="Description2" class="upper">Description (facultatif): </label>
                    <textarea name="Description" id="Description2" placeholder="Écris içi la description de ton trajet" rows="4" cols="40"><?php echo $Description; ?></textarea>
                </div>
            </div>
            <br/>
            <div class="form-item">
                <div class="Checkboxtel">
                    <input type="checkbox" id="tel2" value='1' name="tel" <?php if($tel==1){ ?>checked="true"<?php }?>> 
                    <label for="tel2">Coche pour rendre ton numéro de téléphone visible sur ton annonce</label>
                    <!--Checkbox pour afficher ou non le numéro de téléphone du créateur de la demande-->
                </div>
            </div>
            <!--On stocke ici l'Id du trajet-->
            <input type="hidden" name="IdTrajet" value="<?php echo $idTrajet; ?>"></input>
            
            <br/>
            <div class="submitForm">
                <input type="submit" class="modifyData" name="send" id="send" value="Envoyer">
            </div>
            <div id="map"></div>


        </form>
    </div>


    <?php
    }

    else{
        ?>
    <!--Formulaire de modification d'une demande de trajet-->
    <div class="infos formDiv" id="infos" >
        <form action="modifTravelAction.php" class="infos-secondary" method="post">
            <!--Stockage des coordonnées-->
            <input type="hidden" name="long" id="long" value="<?php if($TypeTrajet=="Aller"){echo $lngdep;}else{echo $lngarr;}?>">
            <input type="hidden" name="lat" id="lat" value="<?php if($TypeTrajet=="Aller"){echo $latdep;}else{echo $latarr;}?>">
            <input type="hidden" name="isDemande" value="1">
            <input type="hidden" name="AllerRetour" value="<?php echo $TypeTrajet; ?>">
        
            <!--Groupe contenant les informations en lien avec des emplacement-->
            <div class="input-group">
                <div class="form-item"><label for="departure" id="departureSpan" class="upper">Ville de départ/arrivée:</label>   <input type="text" class="inputUpper" required="required" name="Ville" id="departure" value="<?php echo $LieuDepart; ?>"></div>
                <div class="form-item"><label for="adresse" id="adresseSpan" class="upper">Adresse de départ/arrivée:</label>   <input type="text" class="inputUpper" required="required" name="Adresse" id="adresse"  value="<?php if($TypeTrajet=="Aller"){echo $AdresseDepart;} else{echo $AdresseArrivee;} ?>"></div>
                <div class="form-item"><label for="arrival" id="arrivalSpan" class="upper">Vers:</label>   <input type="text" class="inputUpper" required="required" name="arrival" id="arrival"  value="<?php echo $LieuArrivee; ?>"></div>
            </div>
            <!--Groupe contenant la date et l'heure de départ-->
            <div class="input-group">
                <div class="form-item datediv">
                    <label for="date" class="upper datelabel">Date de départ:</label>
                    <input type="date" class="inputUpper" id="date" required="required" name="Date-de-Depart" class="Date-de-Depart" min="2022-09-16" value="<?php echo $DateDepart; ?>" >
                </div>
                <div class="timediv">
                    <label for="heureDepart1" class="labeltime">Heure de départ</label>
                        <select name="time" id="heureDepart1" class="selecttime">
                            <option value="00:00" <?php if(substr_replace($HeureDepart ,"", -8)=="00:00"){echo 'selected="selected"';} ?>>00:00</option><option value="00:10" <?php if(substr_replace($HeureDepart ,"", -8)=="00:10"){echo 'selected="selected"';} ?>>00:10</option><option value="00:20" <?php if(substr_replace($HeureDepart ,"", -8)=="00:20"){echo 'selected="selected"';} ?>>00:20</option><option value="00:30" <?php if(substr_replace($HeureDepart ,"", -8)=="00:30"){echo 'selected="selected"';} ?>>00:30</option><option value="00:40" <?php if(substr_replace($HeureDepart ,"", -8)=="00:40"){echo 'selected="selected"';} ?>>00:40</option><option value="00:50" <?php if(substr_replace($HeureDepart ,"", -8)=="00:50"){echo 'selected="selected"';} ?>>00:50</option><option value="01:00" <?php if(substr_replace($HeureDepart ,"", -8)=="01:00"){echo 'selected="selected"';} ?>>01:00</option><option value="01:10" <?php if(substr_replace($HeureDepart ,"", -8)=="01:10"){echo 'selected="selected"';} ?>>01:10</option><option value="01:20" <?php if(substr_replace($HeureDepart ,"", -8)=="01:20"){echo 'selected="selected"';} ?>>01:20</option><option value="01:30" <?php if(substr_replace($HeureDepart ,"", -8)=="01:30"){echo 'selected="selected"';} ?>>01:30</option><option value="01:40" <?php if(substr_replace($HeureDepart ,"", -8)=="01:40"){echo 'selected="selected"';} ?>>01:40</option><option value="01:50" <?php if(substr_replace($HeureDepart ,"", -8)=="01:50"){echo 'selected="selected"';} ?>>01:50</option><option value="02:00" <?php if(substr_replace($HeureDepart ,"", -8)=="02:00"){echo 'selected="selected"';} ?>>02:00</option><option value="02:10" <?php if(substr_replace($HeureDepart ,"", -8)=="02:10"){echo 'selected="selected"';} ?>>02:10</option><option value="02:20" <?php if(substr_replace($HeureDepart ,"", -8)=="02:20"){echo 'selected="selected"';} ?>>02:20</option><option value="02:30" <?php if(substr_replace($HeureDepart ,"", -8)=="02:30"){echo 'selected="selected"';} ?>>02:30</option><option value="02:40" <?php if(substr_replace($HeureDepart ,"", -8)=="02:40"){echo 'selected="selected"';} ?>>02:40</option><option value="02:50" <?php if(substr_replace($HeureDepart ,"", -8)=="02:50"){echo 'selected="selected"';} ?>>02:50</option><option value="03:00" <?php if(substr_replace($HeureDepart ,"", -8)=="03:00"){echo 'selected="selected"';} ?>>03:00</option><option value="03:10" <?php if(substr_replace($HeureDepart ,"", -8)=="03:10"){echo 'selected="selected"';} ?>>03:10</option><option value="03:20" <?php if(substr_replace($HeureDepart ,"", -8)=="03:20"){echo 'selected="selected"';} ?>>03:20</option><option value="03:30" <?php if(substr_replace($HeureDepart ,"", -8)=="03:30"){echo 'selected="selected"';} ?>>03:30</option><option value="03:40" <?php if(substr_replace($HeureDepart ,"", -8)=="03:40"){echo 'selected="selected"';} ?>>03:40</option><option value="03:50" <?php if(substr_replace($HeureDepart ,"", -8)=="03:50"){echo 'selected="selected"';} ?>>03:50</option><option value="04:00" <?php if(substr_replace($HeureDepart ,"", -8)=="04:00"){echo 'selected="selected"';} ?>>04:00</option><option value="04:10" <?php if(substr_replace($HeureDepart ,"", -8)=="04:10"){echo 'selected="selected"';} ?>>04:10</option><option value="04:20" <?php if(substr_replace($HeureDepart ,"", -8)=="04:20"){echo 'selected="selected"';} ?>>04:20</option><option value="04:30" <?php if(substr_replace($HeureDepart ,"", -8)=="04:30"){echo 'selected="selected"';} ?>>04:30</option><option value="04:40" <?php if(substr_replace($HeureDepart ,"", -8)=="04:40"){echo 'selected="selected"';} ?>>04:40</option><option value="04:50" <?php if(substr_replace($HeureDepart ,"", -8)=="04:50"){echo 'selected="selected"';} ?>>04:50</option><option value="05:00" <?php if(substr_replace($HeureDepart ,"", -8)=="05:00"){echo 'selected="selected"';} ?>>05:00</option><option value="05:10" <?php if(substr_replace($HeureDepart ,"", -8)=="05:10"){echo 'selected="selected"';} ?>>05:10</option><option value="05:20" <?php if(substr_replace($HeureDepart ,"", -8)=="05:20"){echo 'selected="selected"';} ?>>05:20</option><option value="05:30" <?php if(substr_replace($HeureDepart ,"", -8)=="05:30"){echo 'selected="selected"';} ?>>05:30</option><option value="05:40" <?php if(substr_replace($HeureDepart ,"", -8)=="05:40"){echo 'selected="selected"';} ?>>05:40</option><option value="05:50" <?php if(substr_replace($HeureDepart ,"", -8)=="05:50"){echo 'selected="selected"';} ?>>05:50</option><option value="06:00" <?php if(substr_replace($HeureDepart ,"", -8)=="06:00"){echo 'selected="selected"';} ?>>06:00</option><option value="06:10" <?php if(substr_replace($HeureDepart ,"", -8)=="06:10"){echo 'selected="selected"';} ?>>06:10</option><option value="06:20" <?php if(substr_replace($HeureDepart ,"", -8)=="06:20"){echo 'selected="selected"';} ?>>06:20</option><option value="06:30" <?php if(substr_replace($HeureDepart ,"", -8)=="06:30"){echo 'selected="selected"';} ?>>06:30</option><option value="06:40" <?php if(substr_replace($HeureDepart ,"", -8)=="06:40"){echo 'selected="selected"';} ?>>06:40</option><option value="06:50" <?php if(substr_replace($HeureDepart ,"", -8)=="06:50"){echo 'selected="selected"';} ?>>06:50</option><option value="07:00" <?php if(substr_replace($HeureDepart ,"", -8)=="07:00"){echo 'selected="selected"';} ?>>07:00</option><option value="07:10" <?php if(substr_replace($HeureDepart ,"", -8)=="07:10"){echo 'selected="selected"';} ?>>07:10</option><option value="07:20" <?php if(substr_replace($HeureDepart ,"", -8)=="07:20"){echo 'selected="selected"';} ?>>07:20</option><option value="07:30" <?php if(substr_replace($HeureDepart ,"", -8)=="07:30"){echo 'selected="selected"';} ?>>07:30</option><option value="07:40" <?php if(substr_replace($HeureDepart ,"", -8)=="07:40"){echo 'selected="selected"';} ?>>07:40</option><option value="07:50" <?php if(substr_replace($HeureDepart ,"", -8)=="07:50"){echo 'selected="selected"';} ?>>07:50</option><option value="08:00" <?php if(substr_replace($HeureDepart ,"", -8)=="08:00"){echo 'selected="selected"';} ?>>08:00</option><option value="08:10" <?php if(substr_replace($HeureDepart ,"", -8)=="08:10"){echo 'selected="selected"';} ?>>08:10</option><option value="08:20" <?php if(substr_replace($HeureDepart ,"", -8)=="08:20"){echo 'selected="selected"';} ?>>08:20</option><option value="08:30" <?php if(substr_replace($HeureDepart ,"", -8)=="08:30"){echo 'selected="selected"';} ?>>08:30</option><option value="08:40" <?php if(substr_replace($HeureDepart ,"", -8)=="08:40"){echo 'selected="selected"';} ?>>08:40</option><option value="08:50" <?php if(substr_replace($HeureDepart ,"", -8)=="08:50"){echo 'selected="selected"';} ?>>08:50</option><option value="09:00" <?php if(substr_replace($HeureDepart ,"", -8)=="09:00"){echo 'selected="selected"';} ?>>09:00</option><option value="09:10" <?php if(substr_replace($HeureDepart ,"", -8)=="09:10"){echo 'selected="selected"';} ?>>09:10</option><option value="09:20" <?php if(substr_replace($HeureDepart ,"", -8)=="09:20"){echo 'selected="selected"';} ?>>09:20</option><option value="09:30" <?php if(substr_replace($HeureDepart ,"", -8)=="09:30"){echo 'selected="selected"';} ?>>09:30</option><option value="09:40" <?php if(substr_replace($HeureDepart ,"", -8)=="09:40"){echo 'selected="selected"';} ?>>09:40</option><option value="09:50" <?php if(substr_replace($HeureDepart ,"", -8)=="09:50"){echo 'selected="selected"';} ?>>09:50</option><option value="10:00" <?php if(substr_replace($HeureDepart ,"", -8)=="10:00"){echo 'selected="selected"';} ?>>10:00</option><option value="10:10" <?php if(substr_replace($HeureDepart ,"", -8)=="10:10"){echo 'selected="selected"';} ?>>10:10</option><option value="10:20" <?php if(substr_replace($HeureDepart ,"", -8)=="10:20"){echo 'selected="selected"';} ?>>10:20</option><option value="10:30" <?php if(substr_replace($HeureDepart ,"", -8)=="10:30"){echo 'selected="selected"';} ?>>10:30</option><option value="10:40" <?php if(substr_replace($HeureDepart ,"", -8)=="10:40"){echo 'selected="selected"';} ?>>10:40</option><option value="10:50" <?php if(substr_replace($HeureDepart ,"", -8)=="10:50"){echo 'selected="selected"';} ?>>10:50</option><option value="11:00" <?php if(substr_replace($HeureDepart ,"", -8)=="11:00"){echo 'selected="selected"';} ?>>11:00</option><option value="11:10" <?php if(substr_replace($HeureDepart ,"", -8)=="11:10"){echo 'selected="selected"';} ?>>11:10</option><option value="11:20" <?php if(substr_replace($HeureDepart ,"", -8)=="11:20"){echo 'selected="selected"';} ?>>11:20</option><option value="11:30" <?php if(substr_replace($HeureDepart ,"", -8)=="11:30"){echo 'selected="selected"';} ?>>11:30</option><option value="11:40" <?php if(substr_replace($HeureDepart ,"", -8)=="11:40"){echo 'selected="selected"';} ?>>11:40</option><option value="11:50" <?php if(substr_replace($HeureDepart ,"", -8)=="11:50"){echo 'selected="selected"';} ?>>11:50</option>
                            <option value="12:00" <?php if(substr_replace($HeureDepart ,"", -8)=="12:00"){echo 'selected="selected"';} ?>>12:00</option><option value="12:10" <?php if(substr_replace($HeureDepart ,"", -8)=="12:10"){echo 'selected="selected"';} ?>>12:10</option><option value="12:20" <?php if(substr_replace($HeureDepart ,"", -8)=="12:20"){echo 'selected="selected"';} ?>>12:20</option><option value="12:30" <?php if(substr_replace($HeureDepart ,"", -8)=="12:30"){echo 'selected="selected"';} ?>>12:30</option><option value="12:40" <?php if(substr_replace($HeureDepart ,"", -8)=="12:40"){echo 'selected="selected"';} ?>>12:40</option><option value="12:50" <?php if(substr_replace($HeureDepart ,"", -8)=="12:50"){echo 'selected="selected"';} ?>>12:50</option><option value="13:00" <?php if(substr_replace($HeureDepart ,"", -8)=="13:00"){echo 'selected="selected"';} ?>>13:00</option><option value="13:10" <?php if(substr_replace($HeureDepart ,"", -8)=="13:10"){echo 'selected="selected"';} ?>>13:10</option><option value="13:20" <?php if(substr_replace($HeureDepart ,"", -8)=="13:20"){echo 'selected="selected"';} ?>>13:20</option><option value="13:30" <?php if(substr_replace($HeureDepart ,"", -8)=="13:30"){echo 'selected="selected"';} ?>>13:30</option><option value="13:40" <?php if(substr_replace($HeureDepart ,"", -8)=="13:40"){echo 'selected="selected"';} ?>>13:40</option><option value="13:50" <?php if(substr_replace($HeureDepart ,"", -8)=="13:50"){echo 'selected="selected"';} ?>>13:50</option><option value="14:00" <?php if(substr_replace($HeureDepart ,"", -8)=="14:00"){echo 'selected="selected"';} ?>>14:00</option><option value="14:10" <?php if(substr_replace($HeureDepart ,"", -8)=="14:10"){echo 'selected="selected"';} ?>>14:10</option><option value="14:20" <?php if(substr_replace($HeureDepart ,"", -8)=="14:20"){echo 'selected="selected"';} ?>>14:20</option><option value="14:30" <?php if(substr_replace($HeureDepart ,"", -8)=="14:30"){echo 'selected="selected"';} ?>>14:30</option><option value="14:40" <?php if(substr_replace($HeureDepart ,"", -8)=="14:40"){echo 'selected="selected"';} ?>>14:40</option><option value="14:50" <?php if(substr_replace($HeureDepart ,"", -8)=="14:50"){echo 'selected="selected"';} ?>>14:50</option><option value="15:00" <?php if(substr_replace($HeureDepart ,"", -8)=="15:00"){echo 'selected="selected"';} ?>>15:00</option><option value="15:10" <?php if(substr_replace($HeureDepart ,"", -8)=="15:10"){echo 'selected="selected"';} ?>>15:10</option><option value="15:20" <?php if(substr_replace($HeureDepart ,"", -8)=="15:20"){echo 'selected="selected"';} ?>>15:20</option><option value="15:30" <?php if(substr_replace($HeureDepart ,"", -8)=="15:30"){echo 'selected="selected"';} ?>>15:30</option><option value="15:40" <?php if(substr_replace($HeureDepart ,"", -8)=="15:40"){echo 'selected="selected"';} ?>>15:40</option><option value="15:50" <?php if(substr_replace($HeureDepart ,"", -8)=="15:50"){echo 'selected="selected"';} ?>>15:50</option><option value="16:00" <?php if(substr_replace($HeureDepart ,"", -8)=="16:00"){echo 'selected="selected"';} ?>>16:00</option><option value="16:10" <?php if(substr_replace($HeureDepart ,"", -8)=="16:10"){echo 'selected="selected"';} ?>>16:10</option><option value="16:20" <?php if(substr_replace($HeureDepart ,"", -8)=="16:20"){echo 'selected="selected"';} ?>>16:20</option><option value="16:30" <?php if(substr_replace($HeureDepart ,"", -8)=="16:30"){echo 'selected="selected"';} ?>>16:30</option><option value="16:40" <?php if(substr_replace($HeureDepart ,"", -8)=="16:40"){echo 'selected="selected"';} ?>>16:40</option><option value="16:50" <?php if(substr_replace($HeureDepart ,"", -8)=="16:50"){echo 'selected="selected"';} ?>>16:50</option><option value="17:00" <?php if(substr_replace($HeureDepart ,"", -8)=="17:00"){echo 'selected="selected"';} ?>>17:00</option><option value="17:10" <?php if(substr_replace($HeureDepart ,"", -8)=="17:10"){echo 'selected="selected"';} ?>>17:10</option><option value="17:20" <?php if(substr_replace($HeureDepart ,"", -8)=="17:20"){echo 'selected="selected"';} ?>>17:20</option><option value="17:30" <?php if(substr_replace($HeureDepart ,"", -8)=="17:30"){echo 'selected="selected"';} ?>>17:30</option><option value="17:40" <?php if(substr_replace($HeureDepart ,"", -8)=="17:40"){echo 'selected="selected"';} ?>>17:40</option><option value="17:50" <?php if(substr_replace($HeureDepart ,"", -8)=="17:50"){echo 'selected="selected"';} ?>>17:50</option><option value="18:00" <?php if(substr_replace($HeureDepart ,"", -8)=="18:00"){echo 'selected="selected"';} ?>>18:00</option><option value="18:10" <?php if(substr_replace($HeureDepart ,"", -8)=="18:10"){echo 'selected="selected"';} ?>>18:10</option><option value="18:20" <?php if(substr_replace($HeureDepart ,"", -8)=="18:20"){echo 'selected="selected"';} ?>>18:20</option><option value="18:30" <?php if(substr_replace($HeureDepart ,"", -8)=="18:30"){echo 'selected="selected"';} ?>>18:30</option><option value="18:40" <?php if(substr_replace($HeureDepart ,"", -8)=="18:40"){echo 'selected="selected"';} ?>>18:40</option><option value="18:50" <?php if(substr_replace($HeureDepart ,"", -8)=="18:50"){echo 'selected="selected"';} ?>>18:50</option><option value="19:00" <?php if(substr_replace($HeureDepart ,"", -8)=="19:00"){echo 'selected="selected"';} ?>>19:00</option><option value="19:10" <?php if(substr_replace($HeureDepart ,"", -8)=="19:10"){echo 'selected="selected"';} ?>>19:10</option><option value="19:20" <?php if(substr_replace($HeureDepart ,"", -8)=="19:20"){echo 'selected="selected"';} ?>>19:20</option><option value="19:30" <?php if(substr_replace($HeureDepart ,"", -8)=="19:30"){echo 'selected="selected"';} ?>>19:30</option><option value="19:40" <?php if(substr_replace($HeureDepart ,"", -8)=="19:40"){echo 'selected="selected"';} ?>>19:40</option><option value="19:50" <?php if(substr_replace($HeureDepart ,"", -8)=="19:50"){echo 'selected="selected"';} ?>>19:50</option><option value="20:00" <?php if(substr_replace($HeureDepart ,"", -8)=="20:00"){echo 'selected="selected"';} ?>>20:00</option><option value="20:10" <?php if(substr_replace($HeureDepart ,"", -8)=="20:10"){echo 'selected="selected"';} ?>>20:10</option><option value="20:20" <?php if(substr_replace($HeureDepart ,"", -8)=="20:20"){echo 'selected="selected"';} ?>>20:20</option><option value="20:30" <?php if(substr_replace($HeureDepart ,"", -8)=="20:30"){echo 'selected="selected"';} ?>>20:30</option><option value="20:40" <?php if(substr_replace($HeureDepart ,"", -8)=="20:40"){echo 'selected="selected"';} ?>>20:40</option><option value="20:50" <?php if(substr_replace($HeureDepart ,"", -8)=="20:50"){echo 'selected="selected"';} ?>>20:50</option><option value="21:00" <?php if(substr_replace($HeureDepart ,"", -8)=="21:00"){echo 'selected="selected"';} ?>>21:00</option><option value="21:10" <?php if(substr_replace($HeureDepart ,"", -8)=="21:10"){echo 'selected="selected"';} ?>>21:10</option><option value="21:20" <?php if(substr_replace($HeureDepart ,"", -8)=="21:20"){echo 'selected="selected"';} ?>>21:20</option><option value="21:30" <?php if(substr_replace($HeureDepart ,"", -8)=="21:30"){echo 'selected="selected"';} ?>>21:30</option><option value="21:40" <?php if(substr_replace($HeureDepart ,"", -8)=="21:40"){echo 'selected="selected"';} ?>>21:40</option><option value="21:50" <?php if(substr_replace($HeureDepart ,"", -8)=="21:50"){echo 'selected="selected"';} ?>>21:50</option><option value="22:00" <?php if(substr_replace($HeureDepart ,"", -8)=="22:00"){echo 'selected="selected"';} ?>>22:00</option><option value="22:10" <?php if(substr_replace($HeureDepart ,"", -8)=="22:10"){echo 'selected="selected"';} ?>>22:10</option><option value="22:20" <?php if(substr_replace($HeureDepart ,"", -8)=="22:20"){echo 'selected="selected"';} ?>>22:20</option><option value="22:30" <?php if(substr_replace($HeureDepart ,"", -8)=="22:30"){echo 'selected="selected"';} ?>>22:30</option><option value="22:40" <?php if(substr_replace($HeureDepart ,"", -8)=="22:40"){echo 'selected="selected"';} ?>>22:40</option><option value="22:50" <?php if(substr_replace($HeureDepart ,"", -8)=="22:50"){echo 'selected="selected"';} ?>>22:50</option><option value="23:00" <?php if(substr_replace($HeureDepart ,"", -8)=="23:00"){echo 'selected="selected"';} ?>>23:00</option><option value="23:10" <?php if(substr_replace($HeureDepart ,"", -8)=="23:10"){echo 'selected="selected"';} ?>>23:10</option><option value="23:20" <?php if(substr_replace($HeureDepart ,"", -8)=="23:20"){echo 'selected="selected"';} ?>>23:20</option><option value="23:30" <?php if(substr_replace($HeureDepart ,"", -8)=="23:30"){echo 'selected="selected"';} ?>>23:30</option><option value="23:40" <?php if(substr_replace($HeureDepart ,"", -8)=="23:40"){echo 'selected="selected"';} ?>>23:40</option><option value="23:50" <?php if(substr_replace($HeureDepart ,"", -8)=="23:50"){echo 'selected="selected"';} ?>>23:50</option>
                        </select>
                    
                </div>
            </div>
            <!--Affichage heure d'arrivée + stockage heure d'arrivée date de départ-->
                <div class="form-item">
                    <label id="arrivalHour" class="arrivalHour">Heure d'arrivée estimée: <?php echo substr_replace($HeureArrivee ,"", -8); ?></label>
                </div>
                <input type="hidden" name="heureArrivee" id="heureArrivee1" value="<?php echo substr_replace($HeureArrivee ,"", -8); ?>">
                <input type="hidden" name="dateArr" id="dateArr" value="<?php echo $DateArrivee; ?>">
            <br/>
            <br>
            <div class="input-group">
                <div class="form-item">
                    <label for="Description" class="upper">Description</label>
                    <textarea name="Description" id="Description" placeholder="Écris içi la description de ton trajet" rows="4" cols="40" ><?php echo $Description ?></textarea>
                </div>
            </div>
            <br/>
            <div class="form-item">
                <div class="Checkboxtel">
                    <input type="checkbox" id="tel" value="1" name="tel" <?php if($tel==1){ ?>checked="true"<?php }?>> 
                    <label for="tel" >Coche pour rendre ton numéro de téléphone visible sur ton annonce</label>
                </div>
            </div>
            <input type="hidden" name="IdTrajet" value="<?php echo $idTrajet; ?>"></input>
            <br/>
            <div class="submitForm">
                <input type="submit" class="modifyData" name="send" id="send" value="Envoyer">
            </div>
        </form>
    </div>
        <?php

    }

}



?>

<script>
    //fonction pour limiter le nombre de caractère dans la description
  var $limitNum = 150;  //Changer cette variable pour modifier la taille limite de la description
$('textarea[name="Description"]').keydown(function() {
    var $this = $(this);

    if ($this.val().length > $limitNum) {
        $this.val($this.val().substring(0, $limitNum));
    }
});
</script>


<script>
    
    if(<?php echo $isDemande; ?>=="1"){
       //Affichage ou non du numéro de téléphone dans la carte du trajet en haut de la page

        document.getElementById("tel").onchange= function(){
            if(document.getElementById("tel").checked === true){
                document.getElementById("DisplayTel").innerHTML="<?php echo "numéro de téléphone: 0".$row2["telephone"]; ?>";
            }
            else{
                document.getElementById("DisplayTel").innerHTML="";
            }
        }


    }
    else{
       
        //modification de la carte de trajet en fonction des inputs
        document.getElementById("Prix").onchange= function() {
            document.getElementById("prix").innerHTML=document.getElementById("Prix").value+"€";
        }

        document.getElementById("tel2").onchange= function(){
            if(document.getElementById("tel2").checked === true){
                document.getElementById("DisplayTel").innerHTML="<?php echo "numéro de téléphone: 0".$row2["telephone"]; ?>";
            }
            else{
                document.getElementById("DisplayTel").innerHTML="";
            }
        }
    }
    //Modification du formulare en fonction de si le trajet est un aller ou un retour
    if("<?php echo $isDemande; ?>"=="1"){
        if("<?php echo $TypeTrajet; ?>"=="Retour") {
            document.getElementById("departureSpan").innerHTML="Lieu de départ :";
            document.getElementById("adresseSpan").innerHTML="Adresse d'arrivée :";
            document.getElementById("arrivalSpan").innerHTML="Ville d'arrivée :";
            document.getElementById('departure').disabled = true;
            document.getElementById('arrival').disabled = false;
            document.getElementById('departure').value = "LBR Festival"; 
            document.getElementById('arrival').value = "<?php echo $LieuArrivee ?>";
        }
        else{
            document.getElementById("departureSpan").innerHTML="Lieu de départ :";
            document.getElementById("adresseSpan").innerHTML="Adresse d'arrivée :";
            document.getElementById("arrivalSpan").innerHTML="Ville d'arrivée :";
            document.getElementById('departure').disabled = false;
            document.getElementById('arrival').disabled = true;
            document.getElementById('departure').value = "<?php echo $LieuDepart ?>"; 
            document.getElementById('arrival').value = "LBR Festival";
        }

    }else{
        if("<?php echo $TypeTrajet; ?>"=="Retour") {
            document.getElementById("departureSpan2").innerHTML="Lieu de départ :";
            document.getElementById("adresseSpan2").innerHTML="Adresse d'arrivée :";
            document.getElementById("arrivalSpan2").innerHTML="Ville d'arrivée :";
            document.getElementById('departure2').disabled = true;
            document.getElementById('arrival2').disabled = false;
            document.getElementById('departure2').value = "LBR Festival"; 
            document.getElementById('arrival2').value = "<?php echo $LieuArrivee ?>";
        }
        else{
            document.getElementById("departureSpan2").innerHTML="Lieu de départ :";
            document.getElementById("adresseSpan2").innerHTML="Adresse d'arrivée :";
            document.getElementById("arrivalSpan2").innerHTML="Ville d'arrivée :";
            document.getElementById('departure2').disabled = false;
            document.getElementById('arrival2').disabled = true;
            document.getElementById('departure2').value = "<?php echo $LieuDepart ?>"; 
            document.getElementById('arrival2').value = "LBR Festival";
        }
    }
    
    
</script>

<script>

let queryCoord = {lat : 0, lng : 0};
    let Duree=0;
    
    //activation des fonctions de recherche de coordonnées et calcul de lheure d'arrivée au changement d'un input en lien avec l'heure ou l'emplacement
        if(<?php echo $isDemande; ?>==0){
            document.getElementById("arrival2").onchange = function(){ 
                document.getElementById("lieuArrivee").innerHTML=document.getElementById("arrival2").value;
                changeLieu(0);
            }
            document.getElementById("departure2").onchange = function(){ 
                document.getElementById("lieuDepart").innerHTML=document.getElementById("departure2").value;
                changeLieu(0);
            }
            document.getElementById("adresse2").onchange = function(){ changeLieu(0);}
    
        }
        else{
            document.getElementById("arrival").onchange = function(){ 
                document.getElementById("lieuArrivee").innerHTML=document.getElementById("arrival").value;
                changeLieu(1);
            }
            document.getElementById("departure").onchange = function(){ 
                document.getElementById("lieuDepart").innerHTML=document.getElementById("departure").value;
                changeLieu(1);
            }  
            document.getElementById("adresse").onchange = function(){changeLieu(1);} 
        }
       
     
//fonction pour récupérer dans une string l'adresse et la ville entrée
    function changeLieu(demande){
        let sens="<?php echo $TypeTrajet;?>";
        let quer="";
        if(demande==0){
            query=document.getElementById("adresse2").value;
        }
        else{
            query=document.getElementById("adresse").value;
        }
        
        if(demande==0){
            if(sens=="Retour"){
            query += " "+document.getElementById("arrival2").value;
            }
            else{
            query += " "+document.getElementById("departure2").value;
            }        
        }
        else{

            if(sens=="Retour"){
            query += " "+document.getElementById("arrival").value;
            }
            else{
            query += " "+document.getElementById("departure").value;
            }
        }
        getDataFromForm(query,demande);
    }






    //fonction pour réupérer les coordonnées
    function getDataFromForm(query,demande){
    
        
        console.log(query);
        
        $.getJSON('http://api.positionstack.com/v1/forward?access_key=3afeb3b8f8e21edd8aa31037edcdc1b6&query=' + query, function(data) {
            
            let arrivee="";
            let depart="";
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();

            queryCoord.lat = data.data[0].latitude;
            queryCoord.lng = data.data[0].longitude;
            
            if(demande==0){
                document.getElementById("lat2").value=queryCoord.lat;
                document.getElementById("long2").value=queryCoord.lng;
            }
            else{
                document.getElementById("lat").value=queryCoord.lat;
                document.getElementById("long").value=queryCoord.lng;
            }
              
                if("<?php echo $TypeTrajet; ?>"=="Retour"){
                    depart=  "<?php echo $AdresseDepart.", ".$LieuDepart; ?>";
                    arrivee=queryCoord;
                }
                else{
                    arrivee= "<?php echo $AdresseArrivee.", ".$LieuArrivee; ?>";;
                    depart=queryCoord;
                }
            
            
 
            
            let request = {
                origin: depart,
                destination: arrivee,
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false,
            };
            
              //calcul de la durée du trajet
            directionsService.route(request, function(result, status) {
              if (status == 'OK') {
                directionsRenderer.setDirections(result);
                let Direction=directionsRenderer.getDirections();
                let Route=Direction.routes[0];
                Duree=Math.round(Route.legs[0].duration.value/60);
                console.log(queryCoord.lng);
                EditArrival(demande);
              }
            });


        });
      }
      if(<?php echo $isDemande; ?>==0){
        document.getElementById("heureDepart2").onchange= function(){
            
            document.getElementById("heureDepart").innerHTML=document.getElementById("heureDepart2").value;
            changeLieu(0);
        }
        document.getElementById("date2").onchange= function(){
            document.getElementById("dateDepart").innerHTML=document.getElementById("date2").value;
            changeLieu(0);
        }
      }
      else{
        document.getElementById("heureDepart1").onchange= function(){
            document.getElementById("heureDepart").innerHTML=document.getElementById("heureDepart1").value;
            changeLieu(1);
        }
        
        document.getElementById("date").onchange= function(){
            document.getElementById("dateDepart").innerHTML=document.getElementById("date").value;
            changeLieu(1);
        }
      }
    
    

    //calcul de la date et l'heure d'arrivée
    function EditArrival(isDemande){
      let DureeHeure=0;
      let temp=Duree;
      while (Duree>60){
              DureeHeure++;
              Duree-=60;            //conversion au format heure:minute de la durée du trajet
            }
            let FinalDuree=DureeHeure+":"+Duree;
            let HeureDepart="";
            
            if(isDemande==0){
                heureDep=document.getElementById("heureDepart2").value;
              
            }                                               //on récupère l'heure de départ donnée par l'utilisateur
            else{
                heureDep=document.getElementById("heureDepart1").value;
            }
            console.log(heureDep);
            let DureeTab = FinalDuree.split(":");                                    //on sépare les heures et les minutes dans un tableau
            var DepTab = heureDep.split(":");
            let FinalMin=0;
            let FinalHour=0;
            if(parseInt(DureeTab[1])+parseInt(DepTab[1])>60){
              FinalHour++;                                                           //si le nombre total de minute dépasse les 60 on les convertit en heure
              FinalMin=-60;
            }
            FinalHour+=parseInt(DureeTab[0])+parseInt(DepTab[0]);                     // on transforme les données en int pour faire le calcul
            FinalMin+=parseInt(DureeTab[1])+parseInt(DepTab[1]);
            let dateDep="";
            if(isDemande==1){
              dateDep=new Date(document.getElementById("date").value);
            }
            else{
              dateDep=new Date(document.getElementById("date2").value);
            }
            
            
            if(FinalMin<10){
              FinalMin="0"+FinalMin;
            }                                                                    //on gère l'affichage de l'heure en rajoutant un 0 pour les nombres a 1 chiffre
            if(FinalHour<10){
              FinalHour="0"+FinalHour;
            }
            else if(FinalHour>23){
              while(FinalHour>23){
                FinalHour-=24;                                                      //On augmente la date d'arrivée si le trajet dépasse minuit
                dateDep.setUTCDate(dateDep.getUTCDate() + 1);
              }
            }
            
            if(isDemande==1){
              document.getElementById("arrivalHour").innerHTML="Heure d'arrivée estimée: "+FinalHour+":"+FinalMin;      //on affiche l'heure d'arrivée
              document.getElementById("dateArr").value=dateDep;                                                         //on place les informations dans les inputs
              document.getElementById("heureArrivee1").value=FinalHour+":"+FinalMin;    
            }
            else{
              document.getElementById("arrivalHour2").innerHTML="Heure d'arrivée estimée: "+FinalHour+":"+FinalMin;
              document.getElementById("dateArr2").value=dateDep;                                                        //on affiche l'heure d'arrivée
              document.getElementById("heureArrivee2").value=FinalHour+":"+FinalMin;                                    //on place les informations dans les inputs
            }          
            document.getElementById("heureArrivee").innerHTML=FinalHour+":"+FinalMin;          //On change l'heure affichée sur la carte
            
            Duree=temp;                                                                     //On redonne a la variable durée la durée précédemment calculée
            
      }


</script>


</body>
</html>