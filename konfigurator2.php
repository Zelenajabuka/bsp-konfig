<?php 
$KundenID = "";
$sql = "";
$msg = "";
if(count($_POST)>0) {
    //te($_POST);

    //zuerst schauen ob der kunde schon existiert
    //  te($_POST);
    //  var_dump($_POST);

        // if (isset$_POST['Namestep2'] == 'step2'){
        if(isset($_POST['Namestep2'])){ //unbedingt so überprüfen sonst
        $sql = "
        SELECT * FROM tbl_Kunden
            WHERE(
            Vorname='" . $conn->real_escape_string($_POST["Vorname"]) . "' AND
            Nachname='" . $conn->real_escape_string($_POST["Nachname"]) . "' AND
            Emailadresse='" . $conn->real_escape_string($_POST["Emailadresse"]) . "'
        )
    ";
            }
       // te($sql);
  //----------wenn was in meine kundendaten drinnen steht dann geht er weiter und sucht nach der id des kunden

        if ($sql!==""){
        $kundenliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error);
        if($kundenliste->num_rows>0) {
            //der eingegebene User existiert
            $msg = '<p class="success">Vielen Dank. Ihre Bestellung wurde weitergeleitet.</p>';
        
            while($Kunde = $kundenliste->fetch_object()){ 
               $KundenID = $Kunde->IDKunde;
            } 

          //  te($KundenID);

        }
        else {
            //dieser User existiert nicht
            //insertstatemant auf kundentabelle und neue id bekannt geben.
            $sql = "
            INSERT INTO tbl_Kunden
                (Nachname, Vorname, GebDatum, Adresse, PLZ,Ort,FIDStaat,Emailadresse,Telefon)
            VALUES (
                '" . $_POST["Nachname"] . "',
                '" . $_POST["Vorname"] . "',
                '" . $_POST["GebDat"] . "',
                '" . $_POST["Adresse"] . "',
                '" . $_POST["PLZ"] . "',
                '" . $_POST["Ort"] . "',
                '" . $_POST["IDStaat"] . "',
                '" . $_POST["Emailadresse"] . "',
                '" . $_POST["Telefon"] . "' 
            )
           ";
           

            $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error);
            if($ok) {
                $msg = '<p class="success">Sie sind nun registriert und ihre Bestellung wird weitergeleitet.</p>';
            }
            else {
                $msg = '<p class="error">Leider konnte der Eintrag nicht wie gewünscht durchgeführt werden.</p>';
            }


        }
    
        if ($KundenID!==""){
            $sql = "
                        INSERT INTO tbl_bestellungen
                            (FIDKunde, FIDRahmentyp, FIDFarbe, FIDMotor, FIDBremse,FIDBeleuchtung)
                        VALUES (
                            '" . $KundenID . "',
                            '" . $_POST["IDRahmentyp"] . "',
                            '" . $_POST["IDFarbe"] . "',
                            '" . $_POST["IDMotor"] . "',
                            '" . $_POST["IDBremse"] . "',
                            '" . $_POST["IDBeleuchtung"] . "' 
                        )
                    ";
                    ta($sql);  
                    $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error);
                            if($ok) {
                                $msg = '<p class="success">Der Eintrag ist erfolgt.</p>';
                            }
                            else {
                                $msg = '<p class="error">Leider konnte der Eintrag nicht wie gewünscht durchgeführt werden.</p>';
                            }
        }
    }

    function Staat_show(){
        $Staaten = show('IDStaat, Bezeichnung', 'tbl_staaten');
        echo createSelect2($Staaten,'IDStaat','Bezeichnung');
    }
}



?>

<?php echo($msg); ?>
 <p>   Ihre Daten: </p>   
        <input type="hidden" name="Namestep2" value="step2" id="Namestep2">
        <input type="hidden" name="KundenID" value="" id="KundenID">
        
        <label class="form-lable"for="Vorname">Vorname:</label>
        <input class="w-100 mb-3" type="text" name="Vorname" id="Vorname">
        
        <label class="form-lable"for="Nachname">Nachname:</label>
        <input class="w-100 mb-3" type="text" name="Nachname" id="Nachname">
        
        <label class="form-lable"for="Emailadresse">Emailadresse:</label>
        <input class="w-100 mb-3" type="email" name="Emailadresse" id="Emailadresse" required>
        
        <label class="form-lable"for="Telefon">Telefon:</label>
        <input class="w-100 mb-3"type="text" name="Telefon" id="Telefon">
        
        <label class="form-lable"for="Adresse">Adresse</label>
        <input class="w-100 mb-3" type="text" name="Adresse" id="Adresse">
        
        <label class="form-lable"for="PLZ">PLZ</label>
        <input class="w-100 mb-3" type="text" name="PLZ" id="PLZ">
       
        <label class="form-lable"for="Ort">Ort</label>
        <input class="w-100 mb-3" type="text" name="Ort" id="Ort">
       
        <label class="form-lable"for="Staat">Staat</label><?php echo(Staat_show()); ?> 
         <input class="w-100 mb-3" type="hidden" name="Staat" id="Staat">  <!-- brauche ich die id wissen will -->
       
        <label class="form-lable"for="GebDat">Geburtsdatum</label>
        <input class="w-100 mb-3" type="Date" name="GebDat" id="GebDat">
       
        <input type="submit" id="submit" name="submit" value="Bestellung abschicken"> 
