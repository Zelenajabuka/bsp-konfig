<?php
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



$conn = new MySQLi("localhost","root","","db_lap_ebikes");
if($conn->connect_errno>0) {
	die("Fehler im Verbindungsaufbau: ".$conn->connect_error);
}

    $suchenach = "%{$_GET['SucheNach']}%";

    $sql = "
    SELECT * FROM tbl_kunden 
    WHERE Nachname like '$suchenach' OR
        Vorname like '$suchenach'
    ";

    $antwort = $conn->query($sql) or die("Fehler in der Query: " . $conn->error);

    while($Zeile = $antwort->fetch_object()) {
    te($Zeile);
    }

    $antwort->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suche</title>
</head>
<body>
<h1>Suche in Datenbank</h1>

<p>Nach welchen Kunden wollen Sie suchen? Geben Sie den Namen ein</p>

<form class="boarder" method="get" class="stdForm" id="frm">
  <label for="suche">Suche:</label>
  <input type="text" id="SucheNach" name="SucheNach"><br><br>
  <input type="submit" value="Submit">
</form>


    
</body>
</html>