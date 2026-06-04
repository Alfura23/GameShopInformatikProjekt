<?php
session_start();

// Alle Session-Variablen entfernen
session_unset();

// Session beenden
session_destroy();

// Zurück zur Startseite
header("Location: ../../index.php");
exit();
