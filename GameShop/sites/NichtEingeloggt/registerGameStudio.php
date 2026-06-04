<?php if (isset($_POST['register'])){

// Connect to the database 
include_once("../../db/dbConnection.php");
include_once("../../db/GameStudioController.php");

// Get the form data 
$GameStudioName = $_POST['GameStudioName'];
$Adresse = $_POST['Adresse'];
$Postleitzahl = $_POST['Postleitzahl'];
$Stadt = $_POST['Stadt'];
$Ansprechpartner_Vorname = $_POST['Ansprechpartner_Vorname'];
$Ansprechpartner_Nachname = $_POST['Ansprechpartner_Nachname'];
$Telefonnummer = $_POST['Telefonnummer'];
$EMailAdresse = $_POST['EMailAdresse'];
$Passwort = $_POST['Passwort'];

GameStudioController::insertGameStudio($GameStudioName, $Adresse, $Postleitzahl, $Stadt, $Ansprechpartner_Vorname, $Ansprechpartner_Nachname, $Telefonnummer, $EMailAdresse, $Passwort);
}
 
header("Location: ../../index.php");

?>