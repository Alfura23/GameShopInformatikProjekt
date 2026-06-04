<!DOCTYPE html>
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
                <div class="collapse navbar-collapse myNavbar">
                     <div class="logo">
			            <a href="../../index.php"> <img class="logo" src="../../images/gear.png" alt=""> </a>
		            </div>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="game_tabelle.php">Alle Spiele</a></li>
                        <li class="nav-item"><a class="nav-link" href="gefilterte_tabelle.php">Suchen</a></li>
                    </ul>
                    
                </div>
            </div>
        </nav>

        <div class="content">
            <h1>Als User registrieren</h1>

            <form action="registerUser.php" method="post">
            <label for="Username">Username:</label> 
            <input id="Username" name="Username" required="" type="text" />
            <label for="EMailAdresse">Email:</label>
            <input id="EMailAdresse" name="EMailAdresse" required="" type="email" />
            <label for="Passwort">Password:</label>
            <input id="Passwort" name="Passwort" required="" type="password" />
            <label for="Geburtsdatum">Geburtsdatum:</label>
            <input id="Geburtsdatum" name="Geburtsdatum" required="" type="date" />
            <input name="register" type="submit" value="register" />
            </form>
        </div>

        <div class="content">
            <h1>Neues Game Studio hinzufügen</h1>

            <form action="registerGameStudio.php" method="post">
            <label for="GameStudioName">Studio Name:</label>
            <input id="GameStudioName" name="GameStudioName" required="" type="text" />
            <label for="Adresse">Adresse:</label>
            <input id="Adresse" name="Adresse" required="" type="text" />
            <label for="Postleitzahl">Postleitzahl:</label>
            <input id="Postleitzahl" name="Postleitzahl" required="" type="text" />
            <label for="Stadt">Stadt:</label>
            <input id="Stadt" name="Stadt" required="" type="text" />
            <label for="Telefonnummer">Telefonnummer:</label>
            <input id="Telefonnummer" name="Telefonnummer" required="" type="text" />
            <label for="EMailAdresse">Email:</label>
            <input id="EMailAdresse" name="EMailAdresse" required="" type="email" />
            <label for="Passwort">Password:</label>
            <input id="Passwort" name="Passwort" required="" type="password" />
            <h4>Ansprechpartner:</h4>
            <label for="Ansprechpartner_Vorname">Vorname:</label>
            <input id="Ansprechpartner_Vorname" name="Ansprechpartner_Vorname" required="" type="text" />
            <label for="Ansprechpartner_Nachname">Nachname:</label>
            <input id="Ansprechpartner_Nachname" name="Ansprechpartner_Nachname" required="" type="text" />
            <input name="register" type="submit" value="register" />
            </form>
        </div>

    </body>
</html>