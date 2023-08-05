<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../css/nav.css">
  <!--Favicon-->
	<link rel="icon" href="../images/LBR Ressources/intiniales.png" type="images/png"/> 
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <title></title>
</head>
<body>
    <nav>
        
        <ul class="nav-links">
            <li>
              <a href="espaceAdmin.php"> Espace admin</a>
            </li>
            <li>
                <a href="TousLesTrajets.php">Les trajets</a>
            </li>
            <li>
              <a href="addtravels.php">Proposer un trajet</a>
            </li>
            <li>
                <a href="Profil.php">Mon Profil</a>
            </li>
            <li>
                <a href="logout.php">Se déconnecter</a>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>   
        </div>
    </nav>

</body>

<script type="text/javascript">

//burger pour rendre la navbar plus responsive
const navSlide = () =>{
const burger = document.querySelector('.burger');
const nav = document.querySelector('.nav-links');
const navLinks = document.querySelectorAll('.nav-links li')


burger.addEventListener('click', () =>{
    nav.classList.toggle('nav-active')

    //animation du burger
    navLinks.forEach((link,index) =>{
    if (link.style.animation) {
        link.style.animation = '';
    } else{
        link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`
    }

});

    burger.classList.toggle('toggle');
});
}



navSlide(); 

</script>

</html>