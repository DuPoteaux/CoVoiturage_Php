<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Covoiturage</title>
	<!--CSS files-->
	<link rel="stylesheet" type="text/css" href="../css/nav.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/alert.css">
	<!--Favicon-->
	
	<!--Google Fonts-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
	rel="stylesheet"> -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-1.6.4.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>

	<script>
		AOS.init();
	</script>

	<?php 
    //***********************
    //AFFICHAGE DES ALERT  
    //***********************
	
	include 'Connexion.php';	//on se connecte a la base de donnée et active les sessions

	if(session_status() != PHP_SESSION_ACTIVE){
		session_start();		//Si les session ne sont pas activées ont les réactive ici
	}
	
	if(isset($_SESSION['alertVerificationEmail'])){
		if($_SESSION['alertVerificationEmail'] == 1){
			?>
			<div class="alert" style="background-color: #70a1ff;">
				<div class="alert-text">Clique sur le lien qui t'as été envoyé par mail.</div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>	
			</div>
			<?php
			$_SESSION['alertVerificationEmail'] = 0; 
		}
	}

	if(isset($_SESSION['alertPropositionBienEnvoyee'])){
		if($_SESSION['alertPropositionBienEnvoyee'] == 1){
			?>
			<div class="alert" style="background-color: #2ed573;">
				<div class="alert-text">La proposition de trajet a bien été envoyée à l'utilisateur.</div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>	
			</div>
			<?php
			$_SESSION['alertPropositionBienEnvoyee'] = 0; 
		}
	}

	if(isset($_SESSION['alertDeuxTrajetsDejaFaits'])){
		if($_SESSION['alertDeuxTrajetsDejaFaits'] == 1){
			?>
			<div class="alert" style="background-color: #EA2027;">
				<div class="alert-text">Tu as déjà soit créé, soit réservé un trajet aller et retour, supprime un de tes trajets pour en créer un autre</div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>
			</div>
			<?php
			$_SESSION['alertDeuxTrajetsDejaFaits'] = 0; 
		}
	}

	if(isset($_SESSION['alertReservationBienEffectuee'])){
		if($_SESSION['alertReservationBienEffectuee'] == 1){
			?>
			<div class="alert" style="background-color: #2ed573;">
				<div class="alert-text">Ta demande de réservation a bien été effectuée, un e-mail a été envoyé au conducteur pour le prévenir. </div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>
			</div>
			<?php
			$_SESSION['alertReservationBienEffectuee'] = 0; 
		}
	}

	if(isset($_SESSION['alertInscriptionReussie'])){
		if($_SESSION['alertInscriptionReussie'] == 1){
			?>
			<div class="alert" style="background-color: #2ed573;">
				<div class="alert-text">Ton email a bien été verifié, tu peux te connecter ! </div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>
			</div>
			<?php
			$_SESSION['alertInscriptionReussie'] = 0; 
		}
	}

	if(isset($_SESSION['alertMailEnvoye'])){
		if($_SESSION['alertMailEnvoye'] == 1){
			?>
			<div class="alert" style="background-color: #2ed573;">
				<div class="alert-text">Un email de vérification a été envoyé, confirme-le pour te connecter. </div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>
			</div>
			<?php
			$_SESSION['alertMailEnvoye'] = 0; 
		}
	}
	if(isset($_SESSION['alertMailDejaVerifie'])){
		if($_SESSION['alertMailDejaVerifie'] == 1){
			?>
			<div class="alert" style="background-color: #EA2027;">
				<div class="alert-text">Oups, tu as déjà vérifié ton adresse mail. </div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>
			</div>
			<?php
			$_SESSION['alertMailDejaVerifie'] = 0; 
		}
	}

	if(isset($_SESSION['alertMailExistePas'])){
		if($_SESSION['alertMailExistePas'] == 1){
			?>
			<div class="alert" style="background-color: #EA2027;">
				<div class="alert-text">Il semblerait que l'adresse mail que tu as rentré n'existe pas.</div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>
			</div>
			<?php
			$_SESSION['alertMailExistePas'] = 0; 
		}
	}


	if(isset($_SESSION['alertPasLeBonChemin'])){
		if($_SESSION['alertPasLeBonChemin'] == 1){
			?>
			<div class="alert" style="background-color: #EA2027;">
				<div class="alert-text">Tu t'es perdu ? </div>
				<div class="croix"><img src="../images/icon/3426000.png"></div>
			</div>
			<?php
			$_SESSION['alertPasLeBonChemin'] = 0; 
		}
	}


	if(isset($_SESSION['logout'])){
		if($_SESSION['logout'] == 1){
			$_SESSION['logout'] = 0;
     		session_destroy();		//déconnexion de l'utilisateur avec une alerte
     		header('location:home.php');
     	}
     }
     ?>	
     <!--********************-->
     <!--	STYLE HOME		-->
     <!--********************-->
     
     <?php 
		include 'NavbarConn.php';	//ajout de la navbar
		?>

		<img class="svgForm" src="../images/Vector 1.svg">

		<div class="title">

	
			<span class="">PLATEFORME DE COVOITURAGE</span>
			
			<div class="radio">
				<span>Je cherche :</span>
				<div>
					<input type="radio" id="aller" name="allerRetour" value="aller" checked>
					<label>Aller</label>
				</div>

				<div>
					<input type="radio" id="retour" name="allerRetour" value="retour">
					<label>Retour</label>
				</div>
			</div>

			<form method="post" action="result.php">
				<div class="form-item">
					<img class="icon" src="../images/icon/free-location-pointer-icon-2961-thumb 1.png">
					<input placeholder="Lieu" type="text" name="lieu" required>
				</div>
				<hr>
				<div class="form-item">
					<input id="inputDate" type="date" min="2022-09-12" max="2022-10-03" name="date" required>
				</div>
				<hr>
				<div class="form-item">
					<img class="icon" src="../images/icon/1077114 1.png">
					<input value="1" min="0" step="1" max="7" type="number" name="nbPlaces">
				</div>
				<input type="text" id="hidden" name="allerRetour" value="aller">
				<input type="submit" value="Rechercher" name="submit">
			</form>

			<script type="text/javascript">

				document.getElementById('aller').addEventListener('change', () =>{
					if(document.getElementById('aller').checked) document.getElementById('hidden').value = "aller";
					console.log(document.getElementById('hidden').value);
				});

				document.getElementById('retour').addEventListener('change', () =>{
					if(document.getElementById('retour').checked) document.getElementById('hidden').value = "retour";
					console.log(document.getElementById('hidden').value);
				});

				const myFunction = () =>{
					document.getElementById("list").scrollIntoView({behavior: "smooth", block: "start"});
				}
			</script>

			<div class="scrolldown">
				<!--Bouton pour scroll la page jusqu'as l'affichage des derniers covoiturages-->
				<button class="scroll" onclick="myFunction()">VOIR LES DERNIERS COVOITURAGES</button>
			</div>
		</div>
		<!--Affichage d edifférentes raison pour lesquels on pourrait vouloir pratiquer le covoiturage-->
		<div data-aos="zoom-in-up"  data-aos-easing="linear"
		data-aos-duration="1000"   data-aos-delay="300">
		<h1>POURQUOI PRATIQUER LE COVOITURAGE?</h1>
	</div>


	<div data-aos="fade-right"  data-aos-easing="linear"
	data-aos-duration="600"   data-aos-delay="500">
	<div class="container">
		
		
		
		<div class="text">
			<h3>FAIRE DES RENCONTRES</h3>

			<p>Le covoiturage te permet de rencontrer des nouvelles personnes durant ton trajet et de rendre plus convivial l’ambiance lors de ton déplacement. Tu y trouveras  peut-être tes futurs partenaires pour faire la fête ! </p>
		</div>
	</div>
</div>

<div data-aos="fade-left"  data-aos-easing="linear"
data-aos-duration="600"   data-aos-delay="500">
<div class="container2">

	<div class="text">
		<h3>ECONOMISER TON ARGENT</h3>

		<p>Le covoiturage te permet aussi d’économiser ton argent ! Plus besoin de payer l’essence et les péages tout seul, tu peux maintenant partager les frais de déplacement avec tes amis !  </p>
	</div>

	<img src="../images/money.png"align="right"> 
</div>
</div>

<div data-aos="fade-up"  data-aos-easing="linear"
data-aos-duration="600"   data-aos-delay="500">
<div class="container3">
	<img src="../images/earth.png"> 

	<div class="text">
		<h3>PROTÉGER LA PLANÈTE</h3>
		<p>Faire du covoiturage, c’est aussi penser à la planète. En partageant le trajet à plusieurs, tu réduis tes émissions de CO2 et le risque d’embouteillages !</p>
	</div>
</div>
</div>
<!--********************************************-->
<!--	Liste des 5 derniers covoiturages		   -->
<!--********************************************-->
<div class="list" id="list">
	<div class="header">
		<img src="../images/car.png">
		<h1>DERNIERS COVOITURAGES</h1>	
	</div>


	<div id="down" class="wrapper">
		<?php

		$requete = "SELECT * FROM trajet WHERE isDemande = 0 ORDER BY DateAjout DESC";
		$result = mysqli_query($conn,$requete);
		$count = 0;
			//on récupère les informations des dernier trajets
		while ($row = mysqli_fetch_assoc($result)) {
			$count++;
				//affichage des horaires
			$hourString1 = substr($row['HeureDepart'],0,2);
			$hourString2 = substr($row['HeureDepart'],3,2);
			$hourStringDeparture = $hourString1."h".$hourString2;


			$hourString3 = substr($row['HeureArrivee'],0,2);
			$hourString4 = substr($row['HeureArrivee'],3,2);
			$hourStringArrival = $hourString3."h".$hourString4;

			$idCompte = $row['IdCompte'];

				//on récupère les informations du créateur du trajet
			$requete2 = "SELECT * FROM compte WHERE IdCompte=$idCompte";
			$result2 = mysqli_query($conn,$requete2);
			$row2 = mysqli_fetch_assoc($result2);


			$pp = $row2['PhotoProfil'];
			if($pp == ""){
					$pp = "";		//Si l'utilisateur ne possède pas de photo de profil on affiche la photo de profil par défaut
				}

				if($count < 5){
					?>

					<div class="item">
						<div class="data-group">
							<!--Affichage des lieux et dates de départ-->
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
							<!--Affichage du prix-->
							<span class="price">
								<?php echo $row['Prix']; ?>FCFA
							</span>
						</div>

						<div class="account-info">
							<img class="profile-picture" src="<?php echo $pp; ?>">
							<div class="profile-info">
								<span class="name"><?php echo $row2['Prenom']." ";echo $row2['Nom']; ?></span>
								<div class="available">
									<?php
									$value = $row['PlacesRestantes'];
									if($value == 1 || $value == 0) echo $value." place restante";
									else echo $value." places restantes"
										//Affichage du nombre de place restantes
										?>
								</div>
								<!--On affiche le numéro de téléphone si l'utilisateur le souhaite-->
                                <div class="available" id="placesRestantes">
                                    <span id="DisplayTel">
									<?php
										if($row["DisplayTel"]==1) echo implode(" ", str_split("0".$row2["telephone"], 2));
		
									?>
                                    </span>
								</div>
							</div>
							<?php $linkint = "nbPass.php?idTrajet=".$row['IdTrajet'];?>
							<div class="book-container"><a class="book" href="<?php echo $linkint ?>" class="button">Réserver</a></div>
						</div>
					</div>

					<?php
				}}
				?>
			</div>

		</div>

<script type="text/javascript"> //JS Alert
let tab = document.getElementsByClassName('croix');
for(let i = 0; i < tab.length;i++){
	tab[i].addEventListener('click', () =>{
		tab[i].parentNode.style.display = 'none';
	})
}
</script>

</body>
</html>
