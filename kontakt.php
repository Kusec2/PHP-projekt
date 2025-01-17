<!DOCTYPE HTML>
<html>
    <head> 
    </head>
    <body>
        <header>
        
           
        </header>
        <main>
            <h1>Kontakt</h1>
            <div class="contact">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2786.0944045323513!2d16.05297241243801!3d45.709142916940806!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47667f7071ca980b%3A0xa2d3fda3c42bc37d!2sCaffe%20bar%20polupansion!5e0!3m2!1shr!2shr!4v1704924562231!5m2!1shr!2shr" width="100%" height="400px" frameborder="0" style="border:0" ></iframe>
                <form action="send_contact.php" id="contact_form" name="contact_form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="_action_" name="_action_" value="TRUE">    
                
                    <label for="ime">Ime *</label><br>
                    <input type="text" id="ime" name="ime" placeholder="Vaše ime..." required><br>

                    <label for="prezime">Prezime *</label><br>
                    <input type="text" id="prezime" name="prezime" placeholder="Vaše prezime..." required><br>

                    <label for="email">E-mail *</label><br>
                    <input type="email" id="email" name="email" placeholder="Vaš E-mail..." required><br>

                    <label>Izaberite opciju</label><br>
                    <input type="radio" name="opcija" value="3D modeliranje"><span style="font-weight:bold;">3D modeliranje</span>
                    <input type="radio" name="opcija" value="3D printanje"><span style="font-weight:bold;">3D printanje</span>
                    <input type="radio" name="opcija" value="3D printanje&modeliranje"><span style="font-weight:bold;">3D modeliranje&printanje</span><br><br>

                    <label for="file" >Izaberite dokument koji želite printati (stl file)</label><br>
                    <input type="file" id="file" name="file" style="border:none; margin:0;"><br><br>

                    <label for="poruka">Poruka</label><br>
                    <textarea id="poruka" name="poruka" placeholder="Napišite nešto..." style="height:100px; width:50%;"></textarea>

                    <input type="submit" name="submit" value="Pošalji">
                </form>
            </div>
            
        </main>
    </body>
</html>