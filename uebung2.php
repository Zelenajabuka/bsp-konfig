<?php
//------------------Testfunktion-----------------------------------
function te($in) {
	if(is_array($in) || is_object($in)) {
		echo('<pre class="msg">');
		print_r($in);
		echo('</pre>');
	}
	else {
		echo('<div class="msg">'.$in.'</div>');
	}
}
//------------------------------------------------------------------
//----------eine verbindung zur Datenbank aufbauen------------------
$conn = new MySQLi("localhost","root","","db_lap_ebikes");
if($conn->connect_errno>0) {
	die("Fehler im Verbindungsaufbau: ".$conn->connect_error);
}
//------------------------------------------------------------------
//------------daten in datenbank schreiben--------------------------
 $sql2 = ""; 
if (isset($_POST['Absenden'])){
        $sql2 = "
        INSERT INTO tbl_kunden
        (Nachname, Vorname,GebDatum, Adresse, FIDStaat, Emailadresse ) 
                    VALUES (
                        '" . $_POST["Nachname"] . "',
                        '" . $_POST["Vorname"] . "',
                        '" . $_POST["GebDatum"] . "',
                        '" . $_POST["Adresse"] . "',
                        '1', 
                        '" . $_POST["Emailadresse"] . "'
                        )
                ";


                    }
//---------------------------------------------------------------------
   if ($sql2 !== ""){ //überprüfung ob in die varibale ein sqlstatement steht und statement absetzen
    $antwort = $conn->query($sql2) or die("Fehler in der Query: " . $conn->error);
   }
//-----------------------------------------------------------------------
$sql ="";//--Alle Daten anzeigen lassen
    if(isset($_GET['Anzeigen'])){
    $sql = "
    SELECT * FROM tbl_kunden 
    ";
    }
//---------------------------------------------------
$antwort2 = "";
 if ($sql !== ""){
   $antwort2 = $conn->query($sql) or die("Fehler in der Query: " . $conn->error);
}    
//----------------------------Daten in einer Tabelle anzeigen-------
if ($antwort2!== ""){
echo('<table class="table">');
   echo('<th>Kundenid</th>');
   echo('<th>Nachname</th>');
   echo('<th>Vorname</th>');
   echo('<th>Emailadresse</th>');
   echo('<th>Geburtsdatum</th>');
   echo('<th>Adresse</th>');
    while($Zeile = $antwort2->fetch_object()) {
       
        echo('
        <tr>
            <td>' . $Zeile->IDKunde . '</td>
            <td>' . $Zeile->Nachname . '</td>
            <td>' . $Zeile->Vorname . '</td>
            <td>' . $Zeile->Emailadresse . '</td>
            <td>' . $Zeile->GebDatum . '</td>
            <td>' . $Zeile->Adresse . '</td>
        </tr>
        ');
    }
echo('</table>');

    $antwort2->close();
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>


<div class="container">
    <form class="boarder" method="POST" class="stdForm" id="frm">
        <label class="form-lable"for="Vorname">Vorname:</label>
        <input class="w-100 mb-3" type="text" name="Vorname" id="Vorname">
        <label class="form-lable"for="Nachname">Nachname:</label>
        <input class="w-100 mb-3" type="text" name="Nachname" id="Nachname">
        <label class="form-lable"for="Emailadresse">Emailadresse:</label>
        <input class="w-100 mb-3" type="email" name="Emailadresse" id="Emailadresse" required>
        <label class="form-lable"for="GebDatum">Geburtsdatum:</label>
        <input class="w-100 mb-3" type="date" name="GebDatum" id="GebDatum" required>
        <label class="form-lable"for="Adresse">Adresse:</label>
        <input class="w-100 mb-3" type="text" name="Adresse" id="Adresse" required>
        <input type="submit" id="submit" name="Absenden" value="Registrieren"> 
    </form>

    <form class="boarder" method="GET" class="stdForm" id="frm">
      <input type="submit" id="submit" name="Anzeigen" value="Anzeigen"> 
    </form>    
</div>
    
</body>
</html>