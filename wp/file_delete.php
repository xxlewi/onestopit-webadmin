<?php
session_start();
require_once 'install/db_config.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zkontroluj, zda byl odeslán formulář pro smazání souboru
if (isset($_POST['delete'])) {
    $file_id = mysqli_real_escape_string($conn, $_POST['file_id']);
    $sql = "DELETE FROM Files WHERE file_id='$file_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: files.php");
        exit();
    } else {
        echo "Chyba při mazání souboru: " . mysqli_error($conn);
    }
}

// pokud nebyl odeslán formulář, přesměrujeme uživatele zpět na files.php
header("Location: files.php");
exit();
?>
