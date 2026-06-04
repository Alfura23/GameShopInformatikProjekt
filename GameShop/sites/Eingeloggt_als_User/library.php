<?php
    session_start()
?>
<!DOCTYPE html>
<html>

    <?php include_once("../../db/reviewController.php"); ?>
    <head>
        <meta charset="utf-8">
        <title>Game-Shop mit Datenbankanbindung</title>

        <link rel="stylesheet" href="../../styles/bootstrap.css">
        <link rel="stylesheet" href="../../styles/styles.css">
        
    </head>

    <body>
        <?php include_once("../../db/gameController.php"); ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse myNavbar">
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


            <table class="table"> 
                <tr>
                    <th>Spielname</th>
                    <th>Game version</th>
                    <th>Preis</th>
                    <th>Release date</th>
                    <th>Durchschnittsscore</th>
                    <th>Genre</th>
                    <th>FSK</th>
                    <th>Download size</th>
                    <th>Game Studio</th>
                    <th>Bild</th>
                </tr>
                <?php 
                    $Gameliste = array();
                        $user = $_SESSION["username"];
                        $GameListe= GameController::getownedGameListe($user);

                    for($i=0; $i<count($GameListe); $i++){
                        $game = $GameListe[$i];
                ?>
                        <tr>
                            <td><?php echo $game->getSpielname(); ?></td>
                            <td><?php echo $game->getGameVersion(); ?></td>
                            <td><?php echo $game->getPreis(); ?></td>
                            <td><?php echo $game->getReleaseDate(); ?></td>
                            <td><?php $avg = reviewController::getAverageScoreByGame($game->getSpielname()); echo $avg > 0 ? number_format($avg, 1, ',', '.') : '-'; ?></td>
                            <td><?php echo $game->getGenre(); ?></td>
                            <td><?php echo $game->getFSK(); ?></td>
                            <td><?php echo $game->getDownloadSizeGB(); ?></td>
                            <td><?php echo $game->getGameStudioName(); ?></td>
                            <td><img src="../../images/<?php echo $game -> getBildname(); ?>" width="100px" height="100px" ></td> 
                        </tr>
                  <?php 
                    }
                ?>
                </tr>

        </div>

    </body>
</html>
