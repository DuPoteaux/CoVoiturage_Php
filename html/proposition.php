<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Réservation</title>
	<!--CSS files-->
	<link rel="stylesheet" type="text/css" href="../css/register.css">
	<link rel="stylesheet" type="text/css" href="../css/proposition.css">

</head>
<body>

	<?php

    include 'Connexion.php';
    if(!isset($_SESSION["login"]) || $_SESSION["login"] == 0){
        header("location:Login.php");
}
    if (isset($_POST["CompteId"]) && (isset($_SESSION['login']) && $_SESSION['login'] != '') && $_SESSION["role"] == 1) {
        $ismyaccount = 0;
        $idCompte = $_POST["CompteId"];
        $sql = "SELECT * FROM compte WHERE IdCompte='" . $idCompte . "'";
    } else {
        $ismyaccount = 1;									//On récupère les informations en fonction de l'id ou du mail en fonction de si l'utilisateur est un admin ou non
        $mail = $_SESSION["mail"];
        $sql = "SELECT * FROM compte WHERE Email='" . $mail . "'";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row["Nom"];
        $mail = $row["Email"];
        $prenom = $row["Prenom"];
        $idCompte = $row["IdCompte"];
        $phone = "0" . $row["telephone"];
        $description = $row["Description"];
	    $pp = $row["PhotoProfil"];              //pp=Photo de Profil
	    $hashedpassword = $row["motDePasse"];

}


		$requete = "SELECT * FROM trajet WHERE isDemande= 0 AND IdCompte='".$idCompte."'";
		$result = mysqli_query($conn,$requete);
		$row = mysqli_fetch_assoc($result);
		if($result->num_rows == 0){
				if($conn->query($requete)){
				$_SESSION['PasDeTrajet'] = 1;
				header("Location:Profil.php");
		}
		}

?>

<div class="main-bloc">
	<div class="suball">
		<div class="left-subbloc">

			<h1>La demande de trajet </h1>
			<div class="trajets" id="trajets">
				<?php
				$idTrajet = $_GET['idTrajet'];
				$typeTrajet = $_GET["typeTrajet"];
		            //trajets conducteur
				$requete = "SELECT * FROM trajet WHERE IdTrajet = '$idTrajet' AND isDemande=1";
				$result = mysqli_query($conn,$requete);
				$count = 0;

					//affichage de la demande de trajet
		        while ($row = mysqli_fetch_assoc($result)) {
		            $count++;

					$hourString1 = substr($row['HeureDepart'],0,2);
					$hourString2 = substr($row['HeureDepart'],3,2);
					$hourStringDeparture = $hourString1."h".$hourString2;


					$hourString3 = substr($row['HeureArrivee'],0,2);
					$hourString4 = substr($row['HeureArrivee'],3,2);
					$hourStringArrival = $hourString3."h".$hourString4;


					$idCompte2 = $row['IdCompte'];
					$requete2 = "SELECT * FROM compte WHERE IdCompte='$idCompte2'";
					$result2 = mysqli_query($conn,$requete2);
					$row2 = mysqli_fetch_assoc($result2);

					?>

					<div class="item">
						<div class="data-group">
							<span class="horaire">
								<?php echo $hourStringDeparture; ?>
							</span>
							<span class="place">
								<?php echo ($row['LieuDepart']); ?>
							</span>

							<span class="date">
								<?php echo ($row['DateDepart']); ?>
							</span>
						</div>

						<div class="data-group">
							<span class="horaire">
								<?php echo $hourStringArrival; ?>
							</span>
							<span class="place">
								<?php echo ($row['LieuArrivee']); ?>
							</span>
						</div>

						<div class="account-info">
							<img class="profile-picture" src="../images/PhotoProfil/<?php if ($row2['PhotoProfil'] != NULL) {
								echo $row2['PhotoProfil'];
								} else {
									echo "defaultpp.jpg";
								} ?>">
								<div class="profile-info">
									<span class="name"><?php echo $row2['Prenom']." ".$row2['Nom']?></span>
									<div class="available">
										<?php
										$value = $row['PlacesRestantes'];
										if($row["isDemande"]==1){ echo "Recherche une voiture";}
										else if($value == 1){ echo $value." place restante";}
										else echo $value." places restantes";
										?>
									</div>
									<!--On affiche le numéro de téléphone si l'utilisateur le souhaite-->
									<div class="available" id="placesRestantes">
                                    <span id="DisplayTel">
									<?php
										if($row["DisplayTel"]==1)echo implode(" ", str_split("0".$row2["telephone"], 2));
		
									?>
                                    </span>
								</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>


			<div class="right-subbloc">
				<h1> Ton trajet </h1>
				<div class="trajets" id="trajets">
					<?php
					$requete = "SELECT * FROM trajet WHERE isDemande=0 AND TypeTrajet='$typeTrajet' AND IdCompte='".$idCompte."'";
					$result = mysqli_query($conn,$requete);
					$count = 0;
					while ($row = mysqli_fetch_assoc($result)) {
						$count++;

						$hourString1 = substr($row['HeureDepart'],0,2);
						$hourString2 = substr($row['HeureDepart'],3,2);
						$hourStringDeparture = $hourString1."h".$hourString2;


						$hourString3 = substr($row['HeureArrivee'],0,2);
						$hourString4 = substr($row['HeureArrivee'],3,2);
						$hourStringArrival = $hourString3."h".$hourString4;

						$idTrajetCon = $row['IdTrajet'];
						$typeTrajetCon = $row['TypeTrajet'];


						$requete2 = "SELECT * FROM compte WHERE IdCompte='$idCompte'";
						$result2 = mysqli_query($conn,$requete2);
						$row2 = mysqli_fetch_assoc($result2);

						?>

						<div class="item">
							<div class="data-group">
								<span class="horaire">
									<?php echo $hourStringDeparture; ?>
								</span>
								<span class="place">
									<?php echo ($row['LieuDepart']); ?>
								</span>

								<span class="date">
									<?php echo ($row['DateDepart']); ?>
								</span>
							</div>

							<div class="data-group">
								<span class="horaire">
									<?php echo $hourStringArrival; ?>
								</span>
								<span class="place">
									<?php echo ($row['LieuArrivee']); ?>
								</span>

								<span class="price">
									<?php echo $row['Prix']; ?>€
								</span>
							</div>

							<div class="account-info">
								<img class="profile-picture" src="../images/PhotoProfil/<?php if ($row2['PhotoProfil'] != NULL) {
									echo $row2['PhotoProfil'];
									} else {
										echo "defaultpp.jpg";
									} ?>">
									<div class="profile-info">
										<span id="driverName" class="name"><?php echo $prenom." ".$nom?></span>
										<div class="available">
											<?php
											$value = $row['PlacesRestantes'];
											if($value == 1) echo $value." place restante";
											else echo $value." places restantes";
											?>
										</div>
										<!--On affiche le numéro de téléphone si l'utilisateur le souhaite-->
										<div class="available" id="placesRestantes">
                                    <span id="DisplayTel">
									<?php
										if($row["DisplayTel"]==1)echo implode(" ", str_split("0".$row2["telephone"], 2));
		
									?>
                                    </span>
								</div>
									</div>

								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="question">


				<h1>Tu veux proposer ton trajet?</h1>

			</div>
			<form action="propositionAction.php" method="post">
				<input class="hidden" type="text" name="idDemande" value="<?php echo $_GET['idTrajet']; ?>">
				<input class="hidden" type="text" name="idTrajet2" value="<?php echo $idTrajetCon;?>">
				<input class="hidden" type="text" name="typeTrajet2" value="<?php echo $typeTrajetCon;?>">
				<input type="submit"  value="Bien sûr" class="accept">
				<a href="TousLesTrajets.php" class="decline" >En fait, non</a>
			</form>
			
		</div>
	</body>
	</html>
