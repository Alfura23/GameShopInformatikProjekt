<?php
    session_start();
    include_once("../../db/dbConnection.php");
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
        <?php 
            include_once("../../db/gameController.php"); 
            $error = null;
        
            if(isset($_POST["Spielname"]) && isset($_POST["GameVersion"]) && isset($_POST["Preis"]) && isset($_POST["ReleaseDate"]) && isset($_POST["Bildname"]) && isset($_POST["Genre"]) && isset($_POST["FSK"]) && isset($_POST["DownloadSizeGB"]) ){
                if(GameController::existsGame($_POST["Spielname"])){
                    $error = "Dieses Spiel existiert bereits.";
                } else {
                    GameController::insertGame($_POST["Spielname"], $_POST["GameVersion"], $_POST["Preis"], $_POST["ReleaseDate"], $_POST["Genre"], $_POST["FSK"], $_POST["DownloadSizeGB"], $_POST["Bildname"], $_SESSION["studio_id"]);
                    header("Location: neues_spiel.php");
                    exit;
                }
            }
        ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse myNavbar">
                     <div class="logo">
			            <a href="index3.php"> <img class="logo" src="../../images/gear.png" alt=""> </a>
		            </div>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="game_tabelle.php">Alle Spiele</a></li>
                        <li class="nav-item"><a class="nav-link" href="gefilterte_tabelle.php">Suchen</a></li>
                        <li class="nav-item"><a class="nav-link" href="neues_spiel.php">Spiel hinzufügen</a></li>
                    </ul>
                    <div class="register-login">
                        <span class="nav-link" style="color: white;"><?php echo htmlspecialchars($_SESSION['studio_name']); ?></span>
                            <a href="logout.php" class="btn btn-outline-light">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content">
            <h1>Neues Game hinzufügen</h1>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="neues_spiel.php" method="post">
                <div class="form-group">
                    <label for="Spielname">Spielname:</label> 
                    <input id="Spielname" class="form-control" type="text" name="Spielname" required>
                </div>
                <div class="form-group">
                    <label for="GameVersion">Game Version:</label> 
                    <input id="GameVersion" class="form-control" type="number" step=".001" name="GameVersion" required>
                </div>
                <div class="form-group">
                    <label for="Preis">Preis:</label>
                     <input id="Preis" class="form-control" type="number" step=".01" name="Preis" required>
                </div>
                <div class="form-group">
                    <label for="ReleaseDate">Release Date: (jjjj-mm-dd)</label> 
                    <input id="ReleaseDate" class="form-control" type="date" name="ReleaseDate" required>
                </div>
                <div class="form-group">
                    <label for="Genre">Genre:</label> 
                    <input id="Genre" class="form-control" type="text" name="Genre" required>
                </div>
                <div class="form-group">
                    <label for="FSK">FSK:</label>
                    <select id="FSK" class="form-control" type="number" name="FSK" required>
                        <option>0</option>
                        <option>6</option>
                        <option>12</option>
                        <option>16</option>
                        <option>18</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="DownloadSizeGB">Download size in GB:</label> 
                    <input id="DownloadSizeGB" class="form-control" type="number" step=".1" name="DownloadSizeGB" required>
                </div>
                <div class="form-group">
                    <label for="Bildname">Bildname:</label> 
                    <input id="Bildname" class="form-control" type="text" name="Bildname" required>
                </div>


            
                <input type="submit" class="btn btn-primary">
            </form>

        </div>

    </body>
</html>