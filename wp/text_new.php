<?php
// session_start(); 
// require_once 'install/db_config.php';
require_once 'head.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zpracuj odeslaný formulář
if (isset($_POST['create'])) {
    $text_title = mysqli_real_escape_string($conn, $_POST['text_title']);
    $text_content = mysqli_real_escape_string($conn, $_POST['text_content']);
    $text_type = mysqli_real_escape_string($conn, $_POST['text_type']);
    $text_status = mysqli_real_escape_string($conn, $_POST['text_status']);

    $sql = "INSERT INTO Texts (text_title, text_content, text_type, text_status) VALUES ('$text_title', '$text_content', '$text_type', '$text_status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: texts.php");
        exit();
    } else {
        echo "Chyba při vytváření nového textu: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vytvořit nový text</title>
</head>
<body>
    <h1>Vytvořit nový text</h1>

    <form action="" method="POST">
        <label for="text_title">Titulek:</label>
        <input type="text" name="text_title" id="text_title" required>

        <label for="text_content">Obsah:</label>
        <textarea name="text_content" id="text_content" rows="10" cols="30"></textarea>

        <label for="text_type">Typ:</label>
        <select name="text_type" id="text_type">
            <option value="article">Article</option>
            <option value="caption">Caption</option>
            <option value="other">Other</option>
        </select>

        <label for="text_status">Status:</label>
        <select name="text_status" id="text_status" required>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>

        <button type="submit" name="create">Vytvořit</button>
    </form>
    
</body>
</html>
