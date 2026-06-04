<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Game-Shop mit Datenbankanbindung</title>
        <link rel="stylesheet" href="../../styles/bootstrap.css">
        <link rel="stylesheet" href="../../styles/styles.css">
        
    </head>

    <body>
        <?php include_once("../../db/gameController.php"); ?>
        <?php include_once("../../db/GameStudioController.php"); ?>
        <?php include_once("../../db/reviewController.php"); ?>

        <?php
            // Handle purchase action when requested via GET action=kaufen&id=...
            if (isset($_GET['action']) && $_GET['action'] === 'kaufen') {
                if (!isset($_SESSION['username'])) {
                    // not logged in — redirect to login page
                    header('Location: ../NichtEingeloggt/login.php');
                    exit;
                }
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo 'Kein Spiel angegeben';
                    exit;
                }
                $spielname = (string)$_GET['id'];
                $gameListeForBuy = GameController::getGameListe();
                $foundGame = null;
                foreach ($gameListeForBuy as $g) {
                    if ($g->getSpielname() === $spielname) {
                        $foundGame = $g;
                        break;
                    }
                }
                if ($foundGame === null) {
                    http_response_code(404);
                    echo 'Spiel nicht gefunden';
                    exit;
                }
                // Prevent duplicate purchase: check owned list
                $alreadyOwned = false;
                $ownedList = GameController::getownedGameListe($_SESSION['username']);
                foreach ($ownedList as $og) {
                    if ($og->getSpielname() === $spielname) { $alreadyOwned = true; break; }
                }
                if (!$alreadyOwned) {
                    GameController::kaufen($_SESSION['username'], $spielname);
                }
                header("Location: ../Eingeloggt_als_User/library.php");
                exit;
            }
        ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse myNavbar">
                     <div class="logo">
			            <a href="../../index.php"> <img class="logo" src="../../images/gear.png" alt=""> </a>
		            </div>

                    <?php if (isset($_SESSION['studio_name'])): ?>
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="../Eingeloggt_als_Gamestudio/game_tabelle.php">Alle Spiele</a></li>
                            <li class="nav-item"><a class="nav-link" href="../Eingeloggt_als_Gamestudio/gefilterte_tabelle.php">Suche</a></li>
                            <li class="nav-item"><a class="nav-link" href="../Eingeloggt_als_Gamestudio/neues_spiel.php">Create</a></li>
                        </ul>
                        <div class="register-login">
                            <span class="nav-link" style="color: white;"> 
                                <?php echo 'Hallo, ' . htmlspecialchars($_SESSION['studio_name']);?>
                            </span>
                            <a href="../Eingeloggt_als_Gamestudio/logout.php" class="btn btn-outline-light">Logout</a>
                        </div>
                    <?php elseif (isset($_SESSION['username'])): ?>
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="../Eingeloggt_als_User/game_tabelle.php">Alle Spiele</a></li>
                            <li class="nav-item"><a class="nav-link" href="../Eingeloggt_als_User/gefilterte_tabelle.php">Suchen</a></li>
                            <li class="nav-item"><a class="nav-link" href="../Eingeloggt_als_User/library.php">Bibliothek</a></li>
                        </ul>
                        <div class="register-login">
                            <span class="nav-link" style="color: white;"> 
                                <?php echo 'Hallo, ' . htmlspecialchars($_SESSION['username']);?>
                            </span>
                            <a href="../Eingeloggt_als_User/logout.php" class="btn btn-outline-light">Logout</a>
                        </div>
                    <?php else: ?>
                         <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="../NichtEingeloggt/game_tabelle.php">Alle Spiele</a></li>
                            <li class="nav-item"><a class="nav-link" href="../NichtEingeloggt/gefilterte_tabelle.php">Suche</a></li>
                        </ul>
                        <div class="register-login">
                            <a href="../NichtEingeloggt/login.php" class="btn btn-outline-light">Login</a>
                            <a href="../NichtEingeloggt/registerForm.php" class="btn btn-outline-light">Register</a>   
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </nav>

        <div class="content">
            <?php 
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

                // Check ownership: only show buy-button if user is logged in and does NOT own the game
                $owns = false;
                if (isset($_SESSION['username']) && $game !== null) {
                    $ownedList = GameController::getownedGameListe($_SESSION['username']);
                    foreach ($ownedList as $og) {
                        if ($og->getSpielname() === $game->getSpielname()) { $owns = true; break; }
                    }
                }
            ?>
            <?php if ($game !== null): ?>
                <div class="BildDiv" style="background-image: url('../../images/<?php echo htmlspecialchars($game->getBildname()); ?>');">
                    <h2><?php echo htmlspecialchars($game->getSpielname()); ?></h2>
                </div>
                
                <div class="infoboxR">
                    <h3>Gamestudio</h3>
                    <p><?php echo htmlspecialchars($game->getGameStudioName()); ?></p>
                    <h4>Version</h4>
                    <p><?php echo htmlspecialchars($game->getGameVersion()); ?></p>
                </div>

                <div class="price-section">
                    <h1><?php echo number_format($game->getPreis(), 2, ',', '.'); ?> €</h1>
                    <?php if (isset($_SESSION['username']) && !$owns): ?>
                        <a class="btn btn-primary buy-button" href="game.php?action=kaufen&id=<?php echo urlencode($game->getSpielname()); ?>">Jetzt Kaufen</a>
                    <?php endif; ?>
                </div>
                
                <div class="game-details">
                    <div class="detail-item">
                        <h5>Genre</h5>
                        <p><?php echo htmlspecialchars($game->getGenre()); ?></p>
                    </div>
                    <div class="detail-item">
                        <h5>Veröffentlichung</h5>
                        <p><?php echo htmlspecialchars($game->getReleaseDate()); ?></p>
                    </div>
                    <div class="detail-item">
                        <h5>Bewertung</h5>
                        <p><?php 
                            $average = reviewController::getAverageScoreByGame($game->getSpielname());
                            echo $average > 0 ? number_format($average, 1, ',', '.') . '/10' : 'Noch keine Bewertungen';
                        ?></p>
                    </div>
                    <div class="detail-item">
                        <h5>FSK Freigabe</h5>
                        <p><?php echo htmlspecialchars($game->getFSK()); ?>+</p>
                    </div>
                    <div class="detail-item">
                        <h5>Download Größe</h5>
                        <p><?php echo htmlspecialchars($game->getDownloadSizeGB()); ?> GB</p>
                    </div>                    
                </div>
                <?php if (isset($_SESSION['username'])): ?>
                    <button class="review-button detail-item"><a href="../Eingeloggt_als_User/review.php?id=<?php echo urlencode($game->getSpielname()); ?>">Review schreiben</a></button>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </body>
</html>