<?php include_once("../../db/reviewController.php"); ?>

<?php
    session_start();

    // Only try to insert when the form was submitted via POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Score'], $_POST['ReviewText'])) {
        // Basic checks: user must be logged in and an id must be present in the querystring
                if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
            $error = 'Nicht eingeloggt oder Spiel-ID fehlt.';
        } else {
            $score = floatval($_POST['Score']);
            $text = trim($_POST['ReviewText']);

            reviewController::insertReview($score, $text);
            // Redirect to avoid resubmission
            header('Location: ../games/game.php?id=' . urlencode($_GET['id']) . '&saved=1');
            exit;
        }
    }
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
        <?php ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse myNavbar">
                     <div class="logo">
			            <a href="../../index.php"> <img class="logo" src="../../images/gear.png" alt=""> </a>
		            </div>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="game_tabelle.php">Alle Spiele</a></li>
                        <li class="nav-item"><a class="nav-link" href="gefilterte_tabelle.php">Suchen</a></li>
                        <li class="nav-item"><a class="nav-link" href="library.php">Bibliothek</a></li>
                    </ul>
                    <div class="register-login">
                        <span class="nav-link" style="color: white;"> 
                            <?php echo 'Hallo, ' . htmlspecialchars($_SESSION['username']);?>
                        </span>
                        <a href="../Eingeloggt_als_User/logout.php" class="btn btn-outline-light">Logout</a>
                    </div>
                    
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="detail-item" style="max-width:700px; margin: 0 auto;">
                <h3>Review schreiben</h3>
                <form action="review.php?id=<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" method="post">
                    <div class="mb-3">
                        <label for="ReviewText" class="form-label">Deine Review</label>
                        <textarea id="ReviewText" name="ReviewText" required class="form-control" rows="4"><?php echo htmlspecialchars($_POST['ReviewText'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Score" class="form-label">Score (0 - 10)</label>
                        <input id="Score" name="Score" required type="number" step="0.1" min="0" max="10" class="form-control" value="<?php echo htmlspecialchars($_POST['Score'] ?? ''); ?>" />
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Abschicken</button>
                        <a href="../games/game.php?id=<?php echo isset($_GET['id']) ? urlencode($_GET['id']) : ''; ?>" class="btn btn-secondary">Abbrechen</a>
                    </div>
                </form>
            </div>
        </div>
        

    </body>
</html>