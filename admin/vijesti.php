<?php
	#Dodaj vijesti	
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'dodaj_vijesti') {
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php
		$query  = "INSERT INTO news (title, description, archive)";
		$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', 
		'" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "','" . $_POST['archive'] . "')";
		$result = @mysqli_query($MySQL, $query);
		
		$ID = mysqli_insert_id($MySQL);

		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
			
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "vijesti/".$_picture);

			# test if format is picture
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif' || $ext == '.avif') { 
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno ste dodali sliku!</p>';
				$_SESSION['message-type']='success';
			}
        }
		$_SESSION['message'] .= '<p>Uspješno ste dodali vijest!</p>';
		
		# Redirect
		header("Location: index.php?menu=7&action=2");
	}

	# Kraj dodavanja vijesti

	# Uredi vijesti
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'uredi_vijesti') {
		$query  = "UPDATE news SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', 
		description='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', 
		archive='" . $_POST['archive'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
            
			$_picture = (int)$_POST['edit'] . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "vijesti/".$_picture);
			
			# test if format is picture
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif' || $ext == 'avif') { 
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . (int)$_POST['edit'] . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno ste dodali sliku!</p>';
			}
        }
		
		$_SESSION['message'] = '<p>Uspješno ste uredili vijest</p>';
		
		# Redirect
		header("Location: index.php?menu=7&action=2");
	}
	# Kraj uređivanje vijesti

	# Brisanje vijesti
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
		
		# Delete picture
        $query  = "SELECT picture FROM news";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("news/".$row['picture']); 
		
		# Delete news
		$query  = "DELETE FROM news";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>Uspješno ste obrisali vijest!</p>';
		
		# Redirect
		header("Location: index.php?menu=7&action=2");
	}
	# Kraj brisanja vijesti
	?>

<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <main>
		<?php
		# Pokazi vijesti info
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$query  = "SELECT * FROM news";
			$query .= " WHERE id=".$_GET['id'];
			$query .= " ORDER BY date DESC";
			$result = @mysqli_query($MySQL, $query);
			$row = @mysqli_fetch_array($result);
			print '
			<h2>News overview</h2>
			<div class="vijesti">
				<img src="vijesti/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>
				' . $row['description'] . '
				<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
				<hr>
			</div>
			<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	} 
	# Dodaj vijesti 
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<h2>Dodaj vijesti</h2>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="add_news">
			
			<label for="naslov">Naslov *</label>
			<input type="text" id="naslov" name="naslov" placeholder="Naslov vijesti..." required>

			<label for="opis">Opis*</label>
			<textarea id="opis" name="opis" placeholder="Opis vijesti..." required></textarea>
				
			<label for="slika">Slika</label>
			<input type="file" id="slika" name="slika">
						
			<label for="archive">Archive:</label><br>
            <input type="radio" name="archive" value="Y"> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N" checked> NO
			
			<hr>
			
			<input type="submit" value="Pošalji">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	# Uredi vijesti
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;

		print '
		<h2>Uredi vijesti</h2>
		<form action="" id="news_form_edit" name="news_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="edit_news">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="naslov">Naslov *</label>
			<input type="text" id="naslov" name="naslov" value="' . $row['title'] . '" placeholder="Naslov vijesti..." required>

			<label for="opis">Opis *</label>
			<textarea id="opis" name="opis" placeholder="Opis vijesti..." required>' . $row['description'] . '</textarea>
				
			<label for="slika">Slika</label>
			<input type="file" id="slika" name="slika">
						
			<label for="archive">Archive:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO
			
			<hr>
			
			<input type="submit" value="Pošalji">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
		else {
		print '
		<h2>Vijesti</h2>
		<div id="vijesti">
			<table>
				<thead>
					<tr>
						
							<th width="100"></th>
							<th width="100"></th>
							<th width="100"></th>
						<th>Naslov</th>
						<th>Opis</th>
						<th>Datum</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM news";
				$query .= " ORDER BY date DESC";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>
						<td>' . $row['title'] . '</td>
						<td>';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td>' . pickerDateToMysql($row['date']) . '</td>
						<td>';
							if ($row['archive'] == 'Y') { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['archive'] == 'N') { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
			<a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Add news</a>
		</div>';
	}
	
	
	# Close MySQL connection
	@mysqli_close($MySQL);
	?>
        </main>
    </body>
</html>