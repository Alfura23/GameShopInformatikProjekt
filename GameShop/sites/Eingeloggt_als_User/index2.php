<!DOCTYPE html>
<?php
    session_start();
    include_once("../../db/dbConnection.php");
?>
<html>
    
    <head>
        <meta charset="utf-8">
        <title>Game-Shop mit Datenbankanbindung</title>

        <link rel="stylesheet" href="../../styles/bootstrap.css">
        <link rel="stylesheet" href="../../styles/styles.css">
    </head>
    
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="colla pse navbar-collapse myNavbar">
                     <div class="logo">
			            <a href="index2.php"> <img class="logo" src="../../images/gear.png" alt=""> </a>
		            </div>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="game_tabelle.php">Alle Spiele</a></li>
                        <li class="nav-item"><a class="nav-link" href="gefilterte_tabelle.php">Suchen</a></li>
                        <li class="nav-item"><a class="nav-link" href="library.php">Bibliothek</a></li>
                    </ul>
                    <div class="register-login">
                        <span class="nav-link" style="color: white;"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <a href="logout.php" class="btn btn-outline-light">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="welcome-section">
            <h1>Willkommen im GameShop</h1>
            <p><img src="../../images/gear.png" width="300px" height="300px" ></p>
            <p>Entdecke Millionen x10^(-10000) Spiele aus jeder Zeit von allen Herstellern gesammelt an einem Ort!</p>
        </div>

        <div class="featured-game">
            <h2>Beliebtestes Spiel</h2>
            <?php
                include_once("../../db/gameController.php");
                include_once("../../db/reviewController.php");
                $beliebtestesGame = GameController::getBeliebtestesGameBild();
                if ($beliebtestesGame != null) {
                    echo '<div class="card mb-3" style="max-width: 540px;">';
                    echo '  <div class="row g-0">';
                    echo '    <div class="col-md-4">';
                    echo '      <img src="../../images/' . $beliebtestesGame->getBildname() . '" class="img-fluid rounded-start" alt="' . $beliebtestesGame->getSpielname() . '">';
                    echo '    </div>';
                    echo '    <div class="col-md-8">';
                    echo '      <div class="card-body">';
                    echo '        <h5 class="card-title">' . $beliebtestesGame->getSpielname() . '</h5>';
                    echo '        <p class="card-text">Genre: ' . $beliebtestesGame->getGenre() . '</p>';
                    echo '        <p class="card-text">Durchschnittliche Bewertung: ' . number_format(reviewController::getAverageScoreByGame($beliebtestesGame->getSpielname()), 2) . '/10</p>';
                    echo '      </div>';
                    echo '    </div>';
                    echo '  </div>';
                    echo '</div>';
                } else {
                    echo '<p>Keine Spiele gefunden.</p>';
                }
            ?>

        </div>

        <footer>
			<h3>© 2026</h3>
		</footer>
        
    </body>
</html>
