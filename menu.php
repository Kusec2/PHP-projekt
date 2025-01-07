<nav class="stranice">
    <a href="index.php?menu=1"> 
        <img src="img/3d_printing_logo_.jpg" style="width:75px; float:left;" >
    </a>
<ul>
    <li><a href="index.php?menu=1">Početna</a></li>
    <li><a href="index.php?menu=2">Galerija</a></li>
    <li><a href="index.php?menu=3">Vijesti</a></li>
    <li><a href="index.php?menu=4">O nama</a></li>
    <li><a href="index.php?menu=5">Kontakt</a></li>
    <?php if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false'): ?>
        <li><a href="index.php?menu=6">Registracija</a></li>
        <li><a href="index.php?menu=7">Prijava</a></li>
    <?php elseif ($_SESSION['user']['valid'] == 'true'): ?>
        <li><a href="index.php?menu=8">Admin</a></li>
        <li><a href="signout.php">Odjava</a></li>
    <?php endif; ?>
</ul>
    </nav>
