<?php
$msg = "";
require("includes/conn.inc.php");

$conn = new MySQLi("localhost","root","","db_lap_kino");
if($conn->connect_errno>0) {
	die("Fehler im Verbindungsaufbau: ".$conn->connect_error);
}


if(count($_POST)>0) {
	if(isset($_POST["AGB"]) && $_POST["AGB"]=="AGBOK") {
		$sql = "
			INSERT INTO tbl_anfragen
				(Nachname,Vorname,Geschlecht,Lieblingssportart)
			VALUES (
				'" . $conn->real_escape_string($_POST["Nachname"]) . "',
				'" . $conn->real_escape_string($_POST["Vorname"]) . "',
				'" . $conn->real_escape_string($_POST["Geschlecht"]) . "',
				'" . $conn->real_escape_string($_POST["Lieblingssport"]) . "'
			)
		";
		$ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error);
		if($ok) {
			$msg = '<p class="success">Ihre Anfrage wurde erfolgreich entgegengenommen.</p>';
		}
		else {
			$msg = '<p class="error">Ihre Anfrage konnte leider nicht entgegengenommen werden. Bitte versuchen Sie es erneut.</p>';
		}
	}
	else {
		$msg = '<p class="error">Bitte akzeptieren Sie unsere AGBs.</p>';
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Kino: Anfrage</title>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,500,500italic,700,700italic,300italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="css/kino.css">
<script type="text/javascript" src="includes/js/jquery-3.0.0.min.js"></script>
<script type="application/javascript">

function checkAGB() {
	if(!$("#AGB").is(":checked")) {
		alert("Bitte akzeptieren Sie unsere AGBs");
		return false;
	}
	
	return true;
}
</script>
</head>

<body>
<h1>Anfrage</h1>
<?php echo($msg); ?>
<p>Bitte füllen Sie das unten stehende Formular aus und akzeptieren Sie unsere AGBs:</p>

<form name="frm" id="frm" method="post" class="stdForm" onsubmit="return checkAGB();">
	<label for="Vorname" data-required>Vorname:</label><input type="text" name="Vorname" id="Vorname" required><br>
	<label for="Nachname" data-required>Nachname:</label><input type="text" name="Nachname" id="Nachname" required><br>
	<label for="Geschlecht1"><input type="radio" name="Geschlecht" id="Geschlecht1" value="männlich" checked>männlich</label><br>
	<label for="Geschlecht2"><input type="radio" name="Geschlecht" id="Geschlecht2" value="weiblich" checked>weiblich</label><br>
	<label for="GebDatum">Geburtsdatum:</label><input type="date" name="GebDatum" id="GebDatum" placeholder="17.10.1972"><br>
	<label for="Lieblingssport">Lieblingssport:</label><br>
	<select name="Lieblingssport" id="Lieblingssport">
		<option>Bitte wählen:</option>
		<option>Radfahren</option>
		<option>Klettern</option>
		<option>Krafttraining</option>
		<option>Laufen</option>
		<option>(keine der genannten Sportarten)</option>
	</select><br>
	<label for="AGB"><input type="checkbox" value="AGBOK" name="AGB" id="AGB">Ich akzeptiere die AGBs</label>
	<input type="submit" value="abschicken">
</form>

</body>
</html>