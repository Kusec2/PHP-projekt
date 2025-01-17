<?php 
	
	# Ažurirajte korisnički profil
	if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
		$query  = "UPDATE users SET firstname='" . $_POST['ime'] . "', lastname='" . $_POST['prezime'] . "', 
        email='" . $_POST['email'] . "', username='" . $_POST['korime'] . "', country='" . $_POST['drzava'] . "', 
        archive='" . $_POST['archive'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		# Close MySQL connection
		@mysqli_close($MySQL);
		
		$_SESSION['message'] = '<p>Uspješno ste promijenili korisnički profil!</p>';
        $_SESSION['message_type']='success';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# Kraj ažuriranje korisničkog profila
	
	# Izbriši korisnički profil
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM users";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>Uspješno ste obrisali korisnički profil!</p>';
        $_SESSION['message_type']='success';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# Kraj brisanja korisničkog profila
	
	
	# Prikaži podatke o korisniku
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<div class="pojedinacni-korisnik">
		<h2>Korisnički profil</h2>
		<p><b>Ime:</b> ' . $row['firstname'] . '</p>
		<p><b>Prezime:</b> ' . $row['lastname'] . '</p>
		<p><b>Korisničko ime:</b> ' . $row['username'] . '</p>';
		$_query  = "SELECT * FROM countries";
		$_query .= " WHERE country_code='" . $row['country'] . "'";
		$_result = @mysqli_query($MySQL, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Država:</b> ' .$_row['country_name'] . '</p>
		<p><b>Date:</b> ' . pickerDateToMysql($row['date']) . '</p>
		<hr>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'" class="BackLink">Natrag    </a></p>
		</div>';
	}
	# Uredi korisnički profil
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		/*if ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2) {*/
			$query  = "SELECT * FROM users";
			$query .= " WHERE id=".$_GET['edit'];
			$result = @mysqli_query($MySQL, $query);
			$row = @mysqli_fetch_array($result);
			$checked_archive = false;
			
			print '
            <div class="users">
			<h2>Uredi korisnički profil</h2>
			<form action="" id="register_form" name="register_form" method="POST">
				<input type="hidden" id="_action_" name="_action_" value="TRUE">
				<input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
				
				<label for="ime">Ime *</label><br>
				<input type="text" id="ime" name="ime" value="' . $row['firstname'] . '" placeholder="Vaše ime..." required><br>

				<label for="prezime">Prezime *</label><br>
				<input type="text" id="prezime" name="prezime" value="' . $row['lastname'] . '" placeholder="Vaše prezime..." required><br>
					
				<label for="email">Your E-mail *</label><br>
				<input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Vaš e-mail..." required><br>
				
				<label for="korime">Korisničko ime *<small>(Korisničko ime mora imati min 5 i maks 10 znakova)</small></label><br>
				<input type="text" id="korime" name="korime" value="' . $row['username'] . '" pattern=".{5,10}" placeholder="Vaše korisničko ime..." required><br>
				
				<label for="drzava">Država</label><br>
				<select name="drzava" id="drzava">
					<option value="">Molimo odaberite</option>';
					#Select all countries from database webprog, table countries
					$_query  = "SELECT * FROM countries";
					$_result = @mysqli_query($MySQL, $_query);

					while($_row = @mysqli_fetch_array($_result)) {
						print '<option value="' . htmlspecialchars($_row['country_code']) . '"';
						if (htmlspecialchars($row['country']) == htmlspecialchars($_row['country_code'])) { print ' selected'; }
						print '>' . htmlspecialchars($_row['country_name']) . '</option>';
					}
				print '
				</select><br>
				
				<label for="archive">Archive:</label><br />
				<input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
				<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO
				
				<hr>
				
				<input type="submit" value="Pošalji">
			</form>
			</div>
			<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'" class="BackLink">Natrag</a></p>';
		}
		/*else {
			print '<p>Zabranjeno</p>';
		}*/
	
	else {
		print '
		<h2>Popis korisnika</h2>
		<div class="users">
			<table>
				<thead>
					<tr>
							<th width="16"></th>
							<th width="16"></th>
							<th width="16"></th>
						
						<th>Ime</th>
						<th>Prezime</th>
						<th>E mail</th>
						<th>Država</th>
						<th width="16">Status</th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM users";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr class="akcije">
						<td class="actions"><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
						<td class="actions">';
							/*if ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2) {*/
								print '<a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>';
							/*}*/
						print '
						<td class="actions">';
							/*if ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2) {*/
								print '<a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a>';
							/*}*/
						print '	
						</td>
						<td data-label="Ime"><strong>' . $row['firstname'] . '</strong></td>
						<td data-label="Prezime"><strong>' . $row['lastname'] . '</strong></td>
						<td data-label="Email">' . $row['email'] . '</td>
						<td data-label="Država">';
							$_query  = "SELECT * FROM countries";
							$_query .= " WHERE country_code='" . $row['country'] . "'";
							$_result = @mysqli_query($MySQL, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
						</td>
						<td data-label="Status">';
							if ($row['archive'] == 'Y') { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['archive'] == 'N') { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>