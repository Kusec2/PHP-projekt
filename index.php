<?php
# Database connection
	include ("dbconn.php");

?>
<!DOCTYPE HTML>
<html>
    <head>
        <!--CSS-->
        <link rel="stylesheet" href="style.css">
        <!--End CSS--> 

        <!--meta elements-->
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="some description">
        <meta name="keywords" content="keyword 1,keyword 2, keyword 3,keyword 4,...">
        <meta name="author" content="Marko Kušec">
        <!--favicon meta-->
        <link rel="icon" href="img/favicon2.ico" type="image/x-icon"/>
        <!--end favicon meta-->

        <title>Projektni zadatak</title>
        
    </head>
    <body>
        <header>
            
            <?php include("menu.php");?>
            
        </header>
        <main>
        <?php
        # Homepage
        if (!isset($_GET['menu']) || $_GET['menu'] == 1) { include("home.php"); }
        
        # Galerija
        else if ($_GET['menu'] == 2) { include("galerija.php"); }
        
        # Vijesti
        else if ($_GET['menu'] == 3) { include("vijesti.php"); }
        
        # O nama
        else if ($_GET['menu'] == 4) { include("o nama.php"); }

        # Kontakt
        else if ($_GET['menu'] == 5) { include("kontakt.php"); }

        # Registracija
        else if ($_GET['menu'] == 6) { include("register.php"); }

        # Prijava
        else if ($_GET['menu'] == 7) { include("signin.php"); }

        ?>
            <div class="socialmedia">
                <p>Social media:
                <br>
                <a href="https://www.facebook.com/3dglobe5/" target="_blank"><img src="img/facebook.webp" alt="facebook" title="facebook" style="width:24px; margin-top:0.4em"></a>
                <a href="https://twitter.com/3dglobe1" target="_blank"><img src="img/twitter (X).png" alt="X" title="X" style="height:24px; width: 25px; margin-top:0.4em;"></a>
                <a href="https://www.youtube.com/channel/UCDnKHzub2nofWSyv1hDqWKw" target="_blank"><img src="img/youtube.webp" style=" height:24px; width:24px; margin-top:0.4em"></a>
                </p>
            </div>
        </main>
        <footer>
            <p class="copyright">Copyright &copy; 2024 Marko Kušec</p>
        </footer>
    </body>
</html>