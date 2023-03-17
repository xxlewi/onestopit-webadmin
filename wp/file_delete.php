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

    // Získejte informace o souboru z databáze
    $file_query = "SELECT file_path FROM Files WHERE file_id='$file_id'";
    $file_result = mysqli_query($conn, $file_query);

    if ($file_result && mysqli_num_rows($file_result) > 0) {
        $file_row = mysqli_fetch_assoc($file_result);
        $file_path = $file_row['file_path'];

        // Odstraňte soubor ze souborového systému
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Odstraňte soubor z databáze
        $sql = "DELETE FROM Files WHERE file_id='$file_id'";
        if (mysqli_query($conn, $sql)) {
            header("Location: files.php");
            exit();
        } else {
            echo "Chyba při mazání souboru: " . mysqli_error($conn);
        }
    } else {
        echo "Soubor nebyl nalezen v databázi.";
    }
}

// pokud nebyl odeslán formulář, přesměrujeme uživatele zpět na files.php
header("Location: files.php");
exit();
?>
