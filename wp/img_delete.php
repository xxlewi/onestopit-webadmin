<?php

session_start();
require_once 'head.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zkontroluj, zda byl odeslán formulář
if (isset($_POST['delete'])) {
    $img_id = mysqli_real_escape_string($conn, $_POST['img_id']);

    // získej informace o obrázku
    $sql = "SELECT * FROM Imgs WHERE img_id = '$img_id'";
    $result = mysqli_query($conn, $sql);
    $img = mysqli_fetch_assoc($result);

    // odstraň soubory obrázku a náhledu z úložiště
    unlink('../imgs/' . $img['img_name']);
    unlink('../imgs/thumbnails/' . $img['img_name']);

    // odstraň záznam z databáze
    $sql = "DELETE FROM Imgs WHERE img_id = '$img_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: imgs.php");
        exit();
    } else {
        echo "Chyba při mazání obrázku: " . mysqli_error($conn);
    }
}

?>
