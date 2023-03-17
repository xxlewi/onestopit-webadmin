<?php
session_start();
require_once 'install/db_config.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['text_id'])) {
    $text_id = mysqli_real_escape_string($conn, $_GET['text_id']);
    $sql = "SELECT * FROM Texts WHERE text_id='$text_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    header("Location: texts.php");
    exit();
}

// zpracuj odeslaný formulář
if (isset($_POST['update'])) {
    $text_title = mysqli_real_escape_string($conn, $_POST['text_title']);
    $text_content = mysqli_real_escape_string($conn, $_POST['text_content']);
    $text_type = mysqli_real_escape_string($conn, $_POST['text_type']);
    $text_status = mysqli_real_escape_string($conn, $_POST['text_status']);

    $sql = "UPDATE Texts SET text_title='$text_title', text_content='$text_content', text_type='$text_type', text_status='$text_status' WHERE text_id='$text_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: texts.php");
        exit();
    } else {
        echo "Chyba při aktualizaci textu: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upravit text</title>
</head>
<body>
    <h1>Upravit text</h1>

    <form action="" method="POST">
        <label for="text_title">Titulek:</label>
        <input type="text" name="text_title" id="text_title" value="<?php echo $row['text_title']; ?>" required>

        <label for="text_content">Obsah:</label>
        <textarea name="text_content" id="text_content" rows="10" cols="30"><?php echo $row['text_content']; ?></textarea>

        <label for="text_type">Typ:</label>
        <select name="text_type" id="text_type">
            <option value="article" <?php echo ($row['text_type'] == 'article') ? 'selected' : ''; ?>>Article</option>
            <option value="caption" <?php echo ($row['text_type'] == 'caption') ? 'selected' : ''; ?>>Caption</option>
            <option value="other" <?php echo ($row['text_type'] == 'other') ? 'selected' : ''; ?>>Other</option>
        </select>

        <label for="text_status">Status:</label>
        <input type="text" name="text_status" id="text_status" value="<?php echo $row['text_status']; ?>" required>

        <button type="submit" name="update">Aktualizovat</button>
    </form>
    
</body>
</html>
