<?php 
    include_once("dbConnection.php");
    
    class GameController {

        public static function getGameListe(){
             $stmt = DBConn::getConn()->prepare("SELECT Spielname,GameVersion,Preis,ReleaseDate,Genre,FSK,DownloadSizeGB,Bildname,GameStudioName FROM Game,GameStudio WHERE Game.GameStudio=GameStudio.GID ");
             $stmt->execute();
             $result = $stmt->get_result();

             $GameListe=array();
             while($row=$result->fetch_assoc()){
                $GameListe[] = new Game($row["Spielname"],$row["GameVersion"],$row["Preis"],$row["ReleaseDate"],$row["Genre"],$row["FSK"],$row["DownloadSizeGB"],$row["Bildname"],$row["GameStudioName"]);

             }
             $stmt->close();
             return $GameListe;
        }
            

        public static function getGefilterteGameListe($suchbegriff){
            $suchbegriff = "%" . $suchbegriff . "%";
            $stmt = DBConn::getConn()->prepare("SELECT Spielname,GameVersion,Preis,ReleaseDate,Genre,FSK,DownloadSizeGB,Bildname,GameStudioName FROM Game,GameStudio WHERE Game.GameStudio=GameStudio.GID AND (Spielname LIKE ? OR GameStudioName LIKE ? OR Genre LIKE ?)");
            $stmt->bind_param("sss",$suchbegriff,$suchbegriff,$suchbegriff);
            $stmt->execute();
            $result = $stmt->get_result();

             $GameListe=array();
             while($row=$result->fetch_assoc()){
                $GameListe[] = new Game($row["Spielname"],$row["GameVersion"],$row["Preis"],$row["ReleaseDate"],$row["Genre"],$row["FSK"],$row["DownloadSizeGB"],$row["Bildname"],$row["GameStudioName"]);
            }
            $stmt->close();

            return $GameListe;
        }

        public static function insertGame($Spielname,$GameVersion,$Preis,$ReleaseDate,$Genre,$FSK,$DownloadSizeGB,$Bildname,$GameStudio){
            $stmt = DBConn::getConn()->prepare("INSERT INTO Game(Spielname,GameVersion,Preis,ReleaseDate,Genre,FSK,DownloadSizeGB,Bildname,GameStudio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt -> bind_param("sddssidsi",$Spielname,$GameVersion,$Preis,$ReleaseDate,$Genre,$FSK,$DownloadSizeGB,$Bildname,$GameStudio);
            $stmt -> execute();   
        }

        public static function existsGame($Spielname){
            $stmt = DBConn::getConn()->prepare("SELECT 1 FROM Game WHERE Spielname = ? LIMIT 1");
            $stmt->bind_param("s", $Spielname);
            $stmt->execute();
            $stmt->store_result();
            $exists = $stmt->num_rows > 0;
            $stmt->close();
            return $exists;
        }

        public static function getBeliebtestesGameBild(){
            $beliebtestesGame = null;
            foreach(self::getGameListe() as $game){
                if($beliebtestesGame == null || reviewController::getAverageScoreByGame($game->getSpielname()) > reviewController::getAverageScoreByGame($beliebtestesGame->getSpielname())){
                    $beliebtestesGame = $game;
                }
            }
            // Return the Game object (or null) so callers can access all getters
            return $beliebtestesGame;
        }
        public static function getownedGameListe($user){
            $stmt = DBConn::getConn()->prepare("SELECT Spielname,GameVersion,Preis,ReleaseDate,Genre,FSK,DownloadSizeGB,Bildname,GameStudioName FROM Game,GameStudio,besitzt WHERE Game.GameStudio=GameStudio.GID AND Game.Spielname=besitzt.Game AND besitzt.Username=?");
            $stmt->bind_param("s",$user);
            $stmt->execute();
            $result = $stmt->get_result();

             $GameListe=array();
             while($row=$result->fetch_assoc()){
                $GameListe[] = new Game($row["Spielname"],$row["GameVersion"],$row["Preis"],$row["ReleaseDate"],$row["Genre"],$row["FSK"],$row["DownloadSizeGB"],$row["Bildname"],$row["GameStudioName"]);
            }
            $stmt->close();

            return $GameListe;
        }

        public static function kaufen($user, $spielname){
            $stmt = DBConn::getConn()->prepare("INSERT INTO besitzt(Username, Game) VALUES (?, ?)");
            $stmt->bind_param("ss", $user, $spielname);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        }

    } 

    class Game{
        private $Spielname;
        private $GameVersion;
        private $Preis;
        private $ReleaseDate;
        private $Genre;
        private $FSK;
        private $DownloadSizeGB;
        private $Bildname;
        private $GameStudioName;

        function __construct($Spielname, $GameVersion, $Preis, $ReleaseDate, $Genre, $FSK, $DownloadSizeGB, $Bildname, $GameStudioName){
            $this->Spielname = $Spielname;
            $this->GameVersion = $GameVersion;
            $this->Preis = $Preis;
            $this->ReleaseDate = $ReleaseDate;
            $this->Genre = $Genre;
            $this->FSK = $FSK;
            $this->DownloadSizeGB = $DownloadSizeGB;
            $this->Bildname = $Bildname;
            $this->GameStudioName = $GameStudioName;
        }

        function getSpielname(){
            return $this->Spielname;
        }

        function getGameVersion(){
            return $this->GameVersion;
        }

        function getPreis(){
            return $this->Preis;
        }

        function getReleaseDate(){
            return $this->ReleaseDate;
        }

        function getGenre(){
            return $this->Genre;
        }

        function getFSK(){
            return $this->FSK;
        }

        function getDownloadSizeGB(){
            return $this->DownloadSizeGB;
        }

        function getBildname(){
            return $this->Bildname;
        }

        function getGameStudioName(){
            return $this->GameStudioName;
        }
    }



?>