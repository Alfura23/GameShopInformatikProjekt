<?php
    include_once("dbConnection.php");

        class FirmenController {

                public static function getFirmenListe(){
                $stmt = DBConn::getConn()->prepare("SELECT * FROM Firma");
                $stmt->execute();
                $result = $stmt->get_result();

                $FirmenListe=array();
                while($row=$result->fetch_assoc()){
                $FirmenListe[] = new Game($row["FID"],$row["FirmenName"],$row["Adresse"],$row["Postleitzahl"],$row["Stadt"],$row["Publisher"],$row["GameStudio"],$row["Ansprechpartner_Vorname"],$row["Ansprechpartner_Nachname"],$row["Telefonnummer"],$row["EMailAdresse"]);

                }
                $stmt->close();
                return $FirmenListe;
                }
        }

        class Firmen{
                private 
        }
?>