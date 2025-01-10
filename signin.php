<!DOCTYPE HTML>
<html>
<body>
    <h1>Prijava</h1>
    <div class="prijava">
    <?php
    if ($_POST['_action_'] == FALSE){ ?>
    <form action="" id="signin_form" name="singin_form" method="POST">
        <input type="hidden" id="_action_" name="_action_" value="TRUE">

        <label for="korime">Korisničko ime *</label><br>
        <input type="text" id="korime" name="korime" pattern=".{5,10}" required><br>

        <label for="lozinka">Lozinka *</label><br>
        <input type="password" id="lozinka" name="lozinka" pattern=".{4,}" required><br>

        <input type="submit" value="Pošalji">
    </form>
    <?php
    }
    else if ($_POST['_action_'] == TRUE){
        /*var_dump($_POST);
        exit;*/
        $query="SELECT * FROM users";
        $query .=" WHERE username='" . $_POST['korime'] . "' AND archive='N'";
        $result=@mysqli_query($MySQL, $query);
        $row=@mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        

        if(isset($row['password']) && password_verify($_POST['lozinka'], $row['password'])){
            
            #password_verify https://secure.php.net/manual/en/function.password-verify.php
            $_SESSION['user']['valid']= 'true';
            $_SESSION['user']['id']=$row['id'];
            # 1 -administrator; 2 - editor; 3 - user
            $_SESSION['user']['role']=$row['role'];
            $_SESSION['user']['firstname']=$row['firstname'];
            $_SESSION['user']['lastname']=$row['lastname'];
            $_SESSION['message']= '<p>Dobrodošli, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '!</p>';
            $_SESSION['message_type'] = 'success';  // Tip poruke
            # Redirect to admin website
            header("Location: index.php?menu=8");
        } 
        # Bad username or password
		else {
			unset($_SESSION['user']);
            $_SESSION['message_type'] = 'error';  // Tip poruke
			$_SESSION['message'] = '<p>Unijeli ste krivu email adresu ili lozinku!</p>';
            header("Location: index.php?menu=7");
            exit;
			
            
		}
    }
    ?>

    

    </div>
</body>
</html>