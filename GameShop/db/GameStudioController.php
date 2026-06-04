<?php
    include_once("dbConnection.php");

        class GameStudioController {

                public static function getGameStudioListe(){
                        $stmt = DBConn::getConn()->prepare("SELECT * FROM GameStudio");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $GameStudioListe=array();
                        while($row=$result->fetch_assoc()){
                                $GameStudioListe[] = new GameStudio($row["GID"],$row["GameStudioName"],$row["Adresse"],$row["Postleitzahl"],$row["Stadt"],$row["Ansprechpartner_Vorname"],$row["Ansprechpartner_Nachname"],$row["Telefonnummer"],$row["EMailAdresse"]);
                        }


                        $stmt->close();
                        return $GameStudioListe;
                }

                public static function insertGameStudio($GameStudioName, $Adresse, $Postleitzahl, $Stadt, $Ansprechpartner_Vorname, $Ansprechpartner_Nachname, $Telefonnummer, $EMailAdresse, $Passwort){
                        $stmt = DBConn::getConn()->prepare("INSERT INTO GameStudio(GameStudioName, Adresse, Postleitzahl, Stadt, Ansprechpartner_Vorname, Ansprechpartner_Nachname, Telefonnummer, EMailAdresse, Passwort) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt -> bind_param("ssisssiss", $GameStudioName, $Adresse, $Postleitzahl, $Stadt, $Ansprechpartner_Vorname, $Ansprechpartner_Nachname, $Telefonnummer, $EMailAdresse, $Passwort);
                        $stmt -> execute();   
                }
        }

?>