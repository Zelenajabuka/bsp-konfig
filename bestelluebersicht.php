<?php
require("includes/meta.php");
include("includes/conn.inc.php");
te($_POST);
$sql = "";
var_dump($_POST);
if(isset($_POST['Bestellübersicht'])){

    $sql= "
      SELECT *, RAH.Bezeichnung as RahmBez, 
      MOT.Bezeichnung as MotBez, 
      BRE.Bezeichnung as BreBez,
      BEL.Bezeichnung as BelBez,
      FAR.Bezeichnung as FarBez
      FROM tbl_bestellungen BES
      INNER JOIN tbl_rahmentypen RAH ON RAH.IDRahmentyp = BES.FIDRahmentyp
      INNER JOIN tbl_motoren MOT ON BES.FIDMotor = MOT.IDMotor
      INNER JOIN tbl_bremsen BRE ON BES.FIDBremse  = BRE.IDBremse
      INNER JOIN tbl_farben FAR ON BES.FIDFarbe = FAR.IDFarbe
      INNER JOIN tbl_beleuchtungen BEL ON BES.FIDBeleuchtung = BEL.IDBeleuchtung

      ";

     
	if(strlen($_POST["datumVon"])>0) {    
        $arr_where[] = "BES.DatumBestellung >=  '" . $_POST["datumVon"].  "'";
	}
            
	if(strlen($_POST["datumBis"])>0) {
		$arr_where[] = "BES.DatumBestellung <= '" . $_POST["datumBis"]. "'";
	}
if(isset($_POST['IDMotor'])){
    if(strlen($_POST["IDMotor"])>0) {    
        $arr_where[] = " BES.FIDMotor = '" . $_POST["IDMotor"].  "'";
	}
}

if(isset($_POST['IDRahmentyp'])){
    if(strlen($_POST["IDRahmentyp"])>0) {    
        $arr_where[] = " BES.FIDRahmentyp = '" . $_POST["IDRahmentyp"].  "'";
	}
}
			$sql.= " WHERE(" . implode(" AND ",$arr_where) . ")";



    //   WHERE BES.DatumBestellung BETWEEN '" .$_POST["datumVon"] . "' AND '". $_POST["datumBis"] ."'
    //   AND BES.FIDMotor =  '" . $_POST["IDMotor"] . "'
    //   AND BES.FIDRahmentyp = '". $_POST["IDRahmentyp"]. "'

} 

te($sql);
if ($sql !== ""){
    $result = $conn->query($sql)or die("Fehler in der Query:" .$conn->error);
    echo "<ul>";
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '
        <li>Bestelldatum: ' . $row['DatumBestellung'].'</li><li>' .$row['Preis'] . '</li><ul>
        <li>Rahmentyp: ' . $row['RahmBez'].'</li>
        <li>Farbe: ' . $row['IDFarbe'].'</li>
        <li>Motor: '. $row['MotBez'].'</li>
        <li>Bremse: '. $row['BreBez'].'</li>
        <li>Beleuchtung: '. $row['BelBez'].'</li>
        </ul></li>
        ';
    }
    }else {
    echo "<p>Für dieser Datum gibt es keine Bestelung</p>";
    }
    echo "</ul>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bestellübersicht</title>


</head>
<body>
     
    
 <p>Bitte wählen Sie aus der untersteheneden Navigation aus: </p> 
 
 <nav>   
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="konfigurator.php">Konfigurator</a></li>
        <li><a href="bestelluebersicht.php">Bestellübersicht</a></li>
    </ul>
 </nav>



 <h1>Filter</h1>

<div class="container">
<p>Filter:</p>
    <form name="Bestellübersichform" id="frm" method="POST" class="stdForm">

        <label class="form-lable" for="datumVon">von:</label>
        <input class="w-100 mb-3" type="date" name="datumVon" id="datumVon" placeholder="von" value="">
        
        <label for="datumBis">bis:</label>
        <input class="w-100 mb-3" type="date" name="datumBis" id="datumBis" placeholder="bis" value="">

        <label class="form-lable"for="IDRahmentyp" name="IDRahmentyp">Rahmentyp:</label><?php rahmentyp2_show(); ?> 
        <!-- <input class="w-100 mb-3" type="text" name="IDRahmentyp" id="IDRahmentyp" placeholder="bitte wählen" value=""> -->

        <label class="form-lable"for="IDMotor"name="IDMotor">Motorleistung:</label><?php motorleistung2_show(); ?> 
        <input type="submit" name="Bestellübersicht" value="filtern">
    </form>
</div>
</body>

</html>