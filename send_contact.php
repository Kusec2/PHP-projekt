<?php
session_start();
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ako koristiš Composer

$dotenv = Dotenv::createImmutable(__DIR__); // Provjeri da je __DIR__ točan
$dotenv->load();



// Provjera forme
if (isset($_POST['submit'])) {
    // Učitavanje podataka iz .env datoteke
    $username = $_ENV['EMAIL_USERNAME'];
    $password = $_ENV['EMAIL_PASSWORD'];

    $ime = htmlspecialchars($_POST['ime']);  // Sanitizacija unosa
    $prezime = htmlspecialchars($_POST['prezime']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);  // Sanitizacija e-maila
    $opcija = htmlspecialchars($_POST['opcija']);
    $poruka = htmlspecialchars($_POST['poruka']);

    // Provjera da li je datoteka poslana i validacija
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileTmpPath = $_FILES['file']['tmp_name'];  // Privremena lokacija datoteke
        $fileName = $_FILES['file']['name'];  // Originalno ime datoteke
        $fileSize = $_FILES['file']['size'];  // Veličina datoteke
        $fileType = $_FILES['file']['type'];  // Tip datoteke

        // Provjeri vrstu datoteke (opcionalno, možeš dodati ograničenja)
        $allowedExtensions = ['.jpg', '.jpeg', '.png', '.pdf', '.stl'];  // Dozvoljene ekstenzije
        $ext = strtolower(strrchr($fileName, "."));
        
        if (!in_array($ext, $allowedExtensions)) {
            $_SESSION['message'] = '<p>Neispravan tip datoteke.</p>';
            $_SESSION['message_type'] = 'error';
            header('Location: index.php?menu=5');  // Preusmjeri korisnika na formu
            exit;
        }

        // Inicijalizacija PHPMailer objekta
        $mail = new PHPMailer(true);
        
        try {
            // Postavke servera za slanje e-maila
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Primatelji
            $mail->setFrom($username, 'Marko');
            $mail->addReplyTo($email, "$ime $prezime");
            $mail->addAddress($username);  // Pošaljite sebi

            // Sadržaj e-maila
            $mail->isHTML(true);
            $mail->Subject = 'Kontakt forma - nova poruka';
            $mail->Body = "Ime: $ime $prezime<br>E-mail: $email<br>Opcija: $opcija<br>Poruka: $poruka";

            // Dodavanje datoteke u e-mail
            $mail->addAttachment($fileTmpPath, $fileName);

            // Pošaljite e-mail
            if ($mail->send()) {
                $_SESSION['message'] = '<p>Email je uspješno poslan!</p>'; 
                $_SESSION['message_type']= 'success';
                header('Location: index.php?menu=5');
                
               
            } else {
                $_SESSION['message'] = 'Greška pri slanju e-maila.';
                $_SESSION['message_type'] = 'error';
                header('Location: index.php?menu=5');
            }
        } catch (Exception $e) {
            $_SESSION['message'] = "Greška: {$mail->ErrorInfo}";
            $_SESSION['message_type'] = 'error';
            header('Location: index.php?menu=5');
            var_dump($_SESSION);
        }
    } else {
        $_SESSION['message'] = 'Nema priložene datoteke ili je došlo do greške.';
        $_SESSION['message_type'] = 'error';
    }

}

?>