<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		if (!isset($action)) { $action = 1; } ?>
		<h1>Administracija</h1>
		<div id="admin">
            <nav class="podstranice">
			<ul>
				<li><a href="index.php?menu=8&amp;action=1">Users</a></li>
				<li><a href="index.php?menu=8&amp;action=2">News</a></li>   
			</ul>
    </nav>
            <?php
			# Admin Users
			if ($action == 1) { include("admin/users.php"); }
			
			# Admin Vijesti
			else if ($action == 2) { include("admin/vijesti.php"); }

            /*# Admin Galerija

            else if ($action== 3) {include ("admin/galerija.php");}*/
		?>
		</div>;
        <?php
	}
	else {
		$_SESSION['message'] = '<p>Molimo vas da se registrirate ili prijavite koristeći svoje podatke!</p>';
        $_SESSION['message-type']='error';
		header("Location: index.php?menu=7");
	}
?>