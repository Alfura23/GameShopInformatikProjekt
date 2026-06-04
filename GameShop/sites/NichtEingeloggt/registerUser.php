<?php if (isset($_POST['register'])){

// Connect to the database 
include_once("../../db/dbConnection.php");
include_once("../../db/userController.php");

// Get the form data 
$username = $_POST['Username']; 
$email = $_POST['EMailAdresse']; 
$password = $_POST['Passwort']; 
$birthday = $_POST['Geburtsdatum']; 

GameShopUserController::insertGameShopUser($username, $email, $password, $birthday);
}
 
header("Location: ../../index.php");

?>