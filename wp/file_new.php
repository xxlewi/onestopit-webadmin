<?php
session_start();
require_once 'install/db_config.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// přidat nový soubor do tabulky Files
if (isset($_POST['create'])) {
    $file_name = mysqli_real_escape_string($conn, $_POST['file_name']);
    $file_name = mysqli_real_escape_string($conn, $_POST['file_url']);
    $file_title = mysqli_real_escape_string($conn, $_POST['file_title']);
    $file_description = mysqli_real_escape_string($conn, $_POST['file_description']);
    $file_keywords = mysqli_real_escape_string($conn, $_POST['file_keywords']);
    $file_status = mysqli_real_escape_string($conn, $_POST['file_status']);

    $sql = "INSERT INTO Files (file_name, file_url, file_title, file_description, file_keywords, file_status)
            VALUES ('$file_name','$file_url', '$file_title', '$file_description', '$file_keywords', '$file_status')";
    mysqli_query($conn, $sql);

    header("Location: files.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nový soubor</title>
</head>
<body>
    <h1>Nový soubor</h1>

    <form action="file_new.php" method="POST">
        <div>
            <label for="file_name">Název souboru:</label>
            <input type="text" id="file_name" name="file_name" required>
        </div>        
        <div>
            <label for="file_url">Url souboru:</label>
            <input type="text" id="file_url" name="file_url" required>
        </div>
        <div>
            <label for="file_title">Titulek souboru:</label>
            <input type="text" id="file_title" name="file_title" required>
        </div>
        <div>
            <label for="file_description">Popis souboru:</label>
            <textarea id="file_description" name="file_description" required></textarea>
        </div>
        <div>
            <label for="file_keywords">Klíčová slova souboru:</label>
            <input type="text" id="file_keywords" name="file_keywords" required>
        </div>
        <div>
            <label for="file_status">Status souboru:</label>
            <select id="file_status" name="file_status" required>
                <option value="aktivní">Aktivní</option>
                <option value="neaktivní">Neaktivní</option>
            </select>
        </div>
        <button type="submit" name="create">Přidat soubor</button>
    </form>

</body>
</html>
