<!DOCTYPE HTML>

<html>
    <body>
        <header>
            
        </header> 
        
        <main>
            <h1>Registracija</h1>
            <div class="registracija">
            <?php 
            if ($_POST['_action_'] == FALSE){?>

                <form action="" id="register_form" name="register_form" method="POST">
                    <input type="hidden" id="_action_" name="_action_" value="TRUE">

                    <label for="ime">Ime *</label><br>
                    <input type="text" id="ime" name="ime" placeholder="Vaše ime..." required><br>

                    <label for="prezime">Prezime *</label><br>
                    <input type="text" id="prezime" name="prezime" placeholder="Vaše prezime..." required><br>

                    <label for="email">E-mail *</label><br>
                    <input type="email" id="email" name="email" placeholder="Vaš e-mail..." required><br>

                    <label for="korime">Korisničko ime *<small>(Korisničko ime mora imati min 5 i maks 10 znakova)</small></label><br>
                    <input type="text" id="korime" name="korime" pattern=".{5,10}" placeholder="Vaše korisničko ime..." required><br>

                    <label for="lozinka">Lozinka * <small>(Lozinka mora imati min 4 znakova)</small></label><br>
			        <input type="password" id="lozinka" name="lozinka" placeholder="Lozinka.." pattern=".{4,}" required><br>

                    <label for="drzava">Država</label><br>
                    <select name="drzava" id="drzava">
                        <option value="">Molimo odaberite</option>
                        <?php
                        // Upit za dohvaćanje svih država iz baze podataka
                        $query = "SELECT * FROM countries";
                        $result = @mysqli_query($MySQL, $query);

                        // Prolazak kroz rezultate i stvaranje opcija
                        while ($row = @mysqli_fetch_array($result)) { 
                            ?>
                            <option value="<?php echo htmlspecialchars($row['country_code']); ?>">
                                <?php echo htmlspecialchars($row['country_name']); ?>
                            </option>
                            <?php 
                        } 
                        ?>
                    </select>
                    <input type="submit" value="Pošalji">
            </form>
            
            <?php
            
            } else if ($_POST['_action_'] == TRUE) {
                
                $query  = "SELECT * FROM users";
                $query .= " WHERE email='" .  $_POST['email'] . "'";
                $query .= " OR username='" .  $_POST['korime'] . "'";
                $result = @mysqli_query($MySQL, $query);
                $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Ako postoji korisnik s istim emailom ili username
                if ($row) {
                    // Ispis poruke da korisnik već postoji
                    $_SESSION['message'] = '<p>Korisnik sa ovim email-om i/ili korisničkim imenom već postoji!</p>'; 
                    $_SESSION['message_type']= 'error';
                    
                }
                else {
                    // Kreiranje hashirane lozinke
                    $pass_hash = password_hash($_POST['lozinka'], PASSWORD_DEFAULT, ['cost' => 12]);
            
                    // Unos novog korisnika u bazu
                    $query  = "INSERT INTO users (firstname, lastname, email, username, password, country)";
                    $query .= " VALUES ('" . $_POST['ime'] . "', '" . $_POST['prezime'] . "', '" . $_POST['email'] . "', '" . $_POST['korime'] . "', '" . $pass_hash . "', '" . $_POST['drzava'] . "')";
                    $result = @mysqli_query($MySQL, $query);
                    
                    
                    $_SESSION['message']=  "<p>" . ucfirst(strtolower($_POST['ime'])) . ' ' . ucfirst(strtolower($_POST['prezime'])) . ", hvala na registraciji!</p>";
                    $_SESSION['message_type']= 'success';
                    header("Location: index.php?menu=7");
                    "<hr>";
                }
            }   ?>
        
            
            
        </div>
        </main>
    
    </body>
</html>