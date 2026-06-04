<?php
session_start();

include_once("../../db/dbConnection.php");

$error = "";

function validPassword($inputPassword, $storedPassword) {
    return password_verify($inputPassword, $storedPassword) || $storedPassword === $inputPassword;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["Username"] ?? "");
    $password = $_POST["Passwort"] ?? "";

    if ($username === "" || $password === "") {
        $error = "Bitte Benutzername und Passwort eingeben.";
    } else {
        $conn = DBConn::getConn();
        $loggedIn = false;

        // 1) Normaler GameShopUser
        $stmt = $conn->prepare("SELECT Passwort FROM GameShopUser WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $storedPassword = $row["Passwort"];
            if (validPassword($password, $storedPassword)) {
                $_SESSION["account_type"] = "user";
                $_SESSION["username"] = $username;
                $loggedIn = true;
            }
        }
        $stmt->close();

        // 2) GameStudio, wenn kein normaler User gefunden wurde
        if (!$loggedIn) {
            $stmt = $conn->prepare("SELECT GID, GameStudioName, Passwort FROM GameStudio WHERE GameStudioName = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $storedPassword = $row["Passwort"];
                if (validPassword($password, $storedPassword)) {
                    $_SESSION["account_type"] = "gamestudio";
                    $_SESSION["studio_id"] = $row["GID"];
                    $_SESSION["studio_name"] = $row["GameStudioName"];
                    $loggedIn = true;
                }
            }
            $stmt->close();
        }

        if ($loggedIn) {
            header("Location: ../../index.php");
            exit();
        }

        $error = "Benutzername oder Passwort ist ungültig.";
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GameShop</title>
    <link rel="stylesheet" href="../../styles/bootstrap.css">
    <link rel="stylesheet" href="../../styles/styles.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <h2>Login</h2>

        <?php if ($error !== ""): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="Username" class="form-label">Benutzername</label>
                <input type="text" id="Username" name="Username" class="form-control" required
                    value="<?php echo htmlspecialchars($_POST["Username"] ?? ""); ?>">
            </div>
            <div class="mb-3">
                <label for="Passwort" class="form-label">Passwort</label>
                <input type="password" id="Passwort" name="Passwort" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Anmelden</button>
        </form>

        <p class="mt-3">
            Noch keinen Account? <a href="registerForm.php">Registrieren</a>
        </p>
    </div>
</body>
</html>