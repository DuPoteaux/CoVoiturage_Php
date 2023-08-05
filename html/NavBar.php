<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../css/nav.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
<!--Favicon-->
<link rel="icon" href="../images/LBR Ressources/intiniales.png" type="images/png"/> 
  <title></title>
</head>
<body>
    <nav>
      
        <ul class="nav-links">
            <li>
                <a href="TousLesTrajets.php">Les trajets</a>
            </li>
            <li>
                <a href="register.php">S'inscrire</a>
            </li>
            <li>
               <a href="login.php">Se connecter</a>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>   
        </div>
    </nav>

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