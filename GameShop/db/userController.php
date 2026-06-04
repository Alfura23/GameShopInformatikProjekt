<?php 
    include_once("dbConnection.php");

    class GameShopUserController {

        public static function getGameShopUserListe(){
             $stmt = DBConn::getConn()->prepare("SELECT * FROM GameShopUser");
             $stmt->execute();
             $result = $stmt->get_result();

             $GameListe=array();
             while($row=$result->fetch_assoc()){
                $GameShopUserListe[] = new Game($row["Username"],$row["EMailAdresse"],$row["Passwort"],$row["Geburtsdatum"]);

             }
             $stmt->close();
             return $GameShopUserListe;
        }

        public static function getGefilterteUserListe($suchbegriff){
            $suchbegriff = "%" . $suchbegriff . "%"; 
            $stmt = DBConn::getConn()->prepare("SELECT * FROM GameShopUser WHERE Username LIKE ?");
            $stmt->bind_param("s", $suchbegriff);
            $stmt->execute();
            $result = $stmt->get_result();

            $UserListe = array();
            while($row = $result->fetch_assoc()){
                $UserListe[] = new GameShopUser($row["Username"], $row["EMailAdresse"], $row["Passwort"], $row["Geburtsdatum"]);
            }
            $stmt->close();

            return $UserListe;
        }

        public static function insertGameShopUser($Username, $EMailAdresse, $Passwort, $Geburtsdatum){
            $stmt = DBConn::getConn()->prepare("INSERT INTO GameShopUser(Username, EMailAdresse, Passwort, Geburtsdatum) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $Username, $EMailAdresse, $Passwort, $Geburtsdatum);
            $stmt->execute();
            $stmt->close();
        }
    }

    class GameShopUser{
        private $Username;
        private $EMailAdresse;
        private $Passwort;
        private $Geburtsdatum;


        function __construct($Username, $EMailAdresse, $Passwort, $Geburtsdatum){
            $this->Username = $Username;
            $this->EMailAdresse = $EMailAdresse;
            $this->Passwort = $Passwort;
            $this->Geburtsdatum = $Geburtsdatum;
        }

        function getUsername(){
            return $this->Username;
        }

        function getEMailAdresse(){
            return $this->EMailAdresse;
        }

        function getPasswort(){
            return $this->Passwort;
        }

        function getGeburtsdatum(){
            return $this->Geburtsdatum;
        }

    }

?>