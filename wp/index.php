<html>
    <head>

    <title>WebAdmin Onestopit</title>
    <link rel="stylesheet" type="text/css" href="./wp-style.css">

<nav>
  <ul>
    <li><a href="files.php">Files</a></li>
    <li><a href="file.php">File</a></li>
    <li><a href="templates.php">Templates</a></li>
    <li><a href="texts.php">Text</a></li>
    <li><a href="imgs.php">Img</a></li>
    <li><a href="users.php">Users</a></li>
  </ul>
</nav>
</head>





<?php
session_start();

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zobraz různý obsah v závislosti na uživatelské roli
if ($_SESSION['user_role'] == 'superadmin') {
    echo "Vítejte v aplikaci WebAdmin Onestopit, Super Administrátore.";
    // zde může být kód pro zobrazení informací a nástrojů pro administraci
} else {
    echo "Vítejte v aplikaci WebAdmin Onestopit.";
    // zde může být kód pro zobrazení informací a nástrojů pro běžné uživatele
}
?>


</html>


