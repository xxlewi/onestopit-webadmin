<?php

session_start();
require_once 'head.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zkontroluj, zda byl odeslán formulář
if (isset($_POST['edit'])) {
    $img_id = mysqli_real_escape_string($conn, $_POST['img_id']);

    // získej informace o obrázku
    $sql = "SELECT * FROM Imgs WHERE img_id = '$img_id'";
    $result = mysqli_query($conn, $sql);
    $img = mysqli_fetch_assoc($result);
}

// zkontroluj, zda byl odeslán formulář pro úpravu
if (isset($_POST['submit'])) {
    $img_id = mysqli_real_escape_string($conn, $_POST['img_id']);
    $img_title = mysqli_real_escape_string($conn, $_POST['img_title']);
    $img_description = mysqli_real_escape_string($conn, $_POST['img_description']);
    $img_alt = mysqli_real_escape_string($conn, $_POST['img_alt']);
    $img_seo = mysqli_real_escape_string($conn, $_POST['img_seo']);

    $sql = "UPDATE Imgs SET img_title = '$img_title', img_description = '$img_description', img_alt = '$img_alt', img_seo = '$img_seo' WHERE img_id = '$img_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: imgs.php");
        exit();
    } else {
        echo "Chyba při úpravě obrázku: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Upravit obrázek</title>
</head>
<body>
    <h1>Upravit obrázek</h1>

    <img src="<?php echo '../' . $img['img_path']; ?>" alt="<?php echo $img['img_alt']; ?>" style="max-width: 150px; max-height: 150px;">
    <br><br>

    <form action="img_edit.php" method="POST">
        <input type="hidden" name="img_id" value="<?php echo $img['img_id']; ?>">
        <label for="img_title">Titulek:</label>
        <input type="text" name="img_title" value="<?php echo $img['img_title']; ?>" required>
        <br>
        <label for="img_description">Popis:</label>
        <input type="text" name="img_description" value="<?php echo $img['img_description']; ?>">
        <br>
        <label for="img_alt">Alt:</label>
        <input type="text" name="img_alt" value="<?php echo $img['img_alt']; ?>">
        <br>
        <label for="img_seo">SEO:</label>
        <input type="text" name="img_seo" value="<?php echo $img['img_seo']; ?>">
        <br>
        <button type="submit" name="submit">Upravit</button>
    </form>
    <a href="imgs.php">Zpět</a>


</body>
</html>
