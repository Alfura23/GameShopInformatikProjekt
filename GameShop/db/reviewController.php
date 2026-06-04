<?php 
    include_once("dbConnection.php");
    include_once("gameController.php");
    
    class reviewController {

        public static function getGefilterteReviewListe($suchbegriff){
            $suchbegriff = "%" . $suchbegriff . "%";
            $stmt = DBConn::getConn()->prepare("SELECT RID, Score, ReviewText, Spielname, Username FROM Review WHERE Spielname LIKE ? ");
            $stmt->bind_param("s", $suchbegriff);
            $stmt->execute();
            $result = $stmt->get_result();

            $ReviewListe = array();
            while($row = $result->fetch_assoc()){
                $ReviewListe[] = new Review($row["RID"], $row["Score"], $row["ReviewText"], $row["Spielname"], $row["Username"]);
            }
            $stmt->close();

            return $ReviewListe;
        }

        public static function getAverageScoreByGame($spielname) {
            $stmt = DBConn::getConn()->prepare("SELECT AVG(Score) AS avgScore FROM Review WHERE Spielname = ?");
            $stmt->bind_param("s", $spielname);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['avgScore'] !== null ? floatval($row['avgScore']) : 0;
        }

        // Insert a review for the game identified by index $i (from GameController::getGameListe())
        public static function insertReview($Score, $ReviewText){
            // Ensure session is available
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $gameName = isset($_GET['id']) ? (string)$_GET['id'] : null;
                $gameListe = GameController::getGameListe();
                $game = null;
                if ($gameName === null) {
                    echo '<p>Spiel nicht gefunden</p>';
                } else {
                    foreach($gameListe as $g) {
                        if ($g->getSpielname() === $gameName) {
                            $game = $g;
                            break;
                        }
                    }
                }
            if (!isset($_SESSION["username"])) {
                return false;
            }
            $user = $_SESSION["username"];
            $spielname = $game->getSpielname();
            $stmt = DBConn::getConn()->prepare("INSERT INTO Review(RID, Score, ReviewText, Spielname, Username) VALUES (NULL, ?, ?, ?, ?)");
            $stmt->bind_param("dsss", $Score, $ReviewText, $spielname, $user);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        }
        

    } 

    class Review{
        private $RID;
        private $Score;
        private $ReviewText;
        private $Spielname;
        private $Username;


        function __construct($RID, $Score, $ReviewText, $Spielname, $Username){
            $this->RID = $RID;
            $this->Score = $Score;
            $this->ReviewText = $ReviewText;
            $this->Spielname = $Spielname;
            $this->Username = $Username;
        }

        function getRID(){
            return $this->RID;
        }

        function getScore(){
            return $this->Score;
        }

        function getReviewText(){
            return $this->ReviewText;
        }

        function getSpielname(){
            return $this->Spielname;
        }

        function getUsername(){
            return $this->Username;
        }
    }

?>