<?php 
require("includes/conn.inc.php");

function rahmentyp_show() {
   $Rahmen = show('IDRahmentyp, Bezeichnung', 'tbl_rahmentypen');
   echo createSelect($Rahmen,'IDRahmentyp','Bezeichnung');
}

function rahmenfarbe_show() {
    $Farben = show('IDFarbe, Bezeichnung', 'tbl_farben');
   // echo createSelect($Farben,'IDFarbe','Bezeichnung');
   $r = '<select class="form-select mb-2" name="IDFarbe" >';
   while($Farbe = $Farben->fetch_object()){
   $r.= '<option value=" '. $Farbe-> IDFarbe .' ">' . $Farbe->Bezeichnung . '</option>'; 
   }
   $r.= '</select>';
   return $r;
}


function motorleistung_show() {
    $Motoren = show('IDMotor, Bezeichnung', 'tbl_Motoren');
    //echo createSelect($Motoren,'IDMotor','Bezeichnung');
    $r = '<select class="form-select mb-2" name="IDMotor" >';
    while($Motor = $Motoren->fetch_object()){
    $r.= '<option value=" '. $Motor-> IDMotor .' ">' . $Motor->Bezeichnung . '</option>'; 
    }
    $r.= '</select>';
    return $r;
}

function bremssystem_show(){
    $Bremssysteme = show('IDBremse, Bezeichnung', 'tbl_bremsen');
   // echo createSelect($Bremssysteme,'IDBremse','Bezeichnung');
    $r = '<select class="form-select mb-2" name="IDBremse" >';
    while($Bremse = $Bremssysteme->fetch_object()){
    $r.= '<option value=" '. $Bremse-> IDBremse .' ">' . $Bremse->Bezeichnung . '</option>'; 
    }
    $r.= '</select>';
    return $r;
}
function beleuchtungen_show(){
    $Beleuchtungen = show('IDBeleuchtung, Bezeichnung', 'tbl_beleuchtungen');
    // echo createSelect($Beleuchtungen,'IDBeleuchtung','Bezeichnung'); 
    $r = '<select class="form-select mb-2" name="IDBeleuchtung" >'; //der name ist ausschlaggebend was für ein wert in den getdaten drinnensteht
    while($Beleuchtung = $Beleuchtungen->fetch_object()){
    $r.= '<option value=" '. $Beleuchtung-> IDBeleuchtung .' ">' . $Beleuchtung->Bezeichnung . '</option>'; 
    }
    $r.= '</select>';
    return $r;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
        require("includes/meta.php");
    ?>

    <title>Konfigurator</title>
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

<div class="container">
    <form class="boarder"  method="POST" action="konfigurator.php"class="stdForm" id="frm"> <!--immer in der selben datei-->
        <input type="hidden" name="Namestep1" value="step1" id="Namestep1"> <!--wird nicht angezeigt-->

        <label class="form-lable"for="IDRahmentyp" name="IDRahmentyp">Auswahl des Rahmentyps:</label><?php rahmentyp_show(); ?> 
       
      
        <label class="form-lable"for="IDFarbe"name="IDFarbe">Auswahl des Rahmenfarbe:</label><?php echo(rahmenfarbe_show()); ?> 
        <input class="btn btn-primary w-100 mb-3" type="submit" name ="IDFarbe" id= "IDFarbe" value="ok">
      

        <label class="form-lable"for="IDMotor"name="IDMotor">Auswahl des Motorleistung:</label><?php echo(motorleistung_show()); ?> 
        <input class="btn btn-primary w-100 mb-3" type="submit" name ="IDMotor" id= "IDMotor" value="ok">
      
      
        <label class="form-lable"for="IDBremse"name="IDBremse">Auswahl der Bremsen:</label><?php echo(bremssystem_show()); ?> 
        <input class="btn btn-primary w-100 mb-3" type="submit" name ="IDBremse" id= "IDBremse" value="ok">
    
        <label class="form-lable"for="IDBeleuchtung"name="IDBeleuchtung">Auswahl der Beleuchtung:</label><?php echo(beleuchtungen_show()); ?> 
        <input class="btn btn-primary w-100 mb-3" type="submit" name="submit" id = "Bestellen" value="Bestellen">
        

        <?php
            if (Count($_POST)>1 && $_POST['Namestep1']) {
            include('konfigurator2.php'); 
            }
        ?>

        <?php
          if(isset($_POST['submit']) && ($_POST['submit']== "Bestellung abschicken")){ //überprüfung ob postdaten gesetzt worden sind und wenn ja ob es bestellung abschicken ist
             print_r('Ihre Bestellung wurde abgeschickt!');
          }
        ?>

    </form>
</div>

    
</body>
</html>