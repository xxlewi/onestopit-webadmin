<?php
session_start();
require_once 'install/db_config.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zkontroluj, zda byl odeslán formulář pro smazání textu
if (isset($_POST['delete'])) {
    $text_id = mysqli_real_escape_string($conn, $_POST['text_id']);
    $sql = "DELETE FROM Texts WHERE text_id='$text_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: texts.php");
        exit();
    } else {
        echo "Chyba při mazání textu: " . mysqli_error($conn);
    }
}

// pokud nebyl odeslán formulář, přesměrujeme uživatele zpět na texts.php
header("Location: texts.php");
exit();
?>
