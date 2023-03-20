<?php
function create_thumbnail($src, $dest, $desired_width) {
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);
    $desired_height = floor($height * ($desired_width / $width));
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
    imagejpeg($virtual_image, $dest);
}

session_start();
require_once 'head.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zkontroluj, zda byl odeslán formulář
if (isset($_POST['submit'])) {
    $img_title = mysqli_real_escape_string($conn, $_POST['img_title']);
    $img_description = mysqli_real_escape_string($conn, $_POST['img_description']);
    $img_alt = mysqli_real_escape_string($conn, $_POST['img_alt']);
    $img_seo = mysqli_real_escape_string($conn, $_POST['img_seo']);

    $img_folder = "../imgs/";
    $thumb_folder = "../imgs/thumbnails/";

    if (!file_exists($img_folder)) {
        mkdir($img_folder, 0755, true);
    }
    if (!file_exists($thumb_folder)) {
        mkdir($thumb_folder, 0755, true);
    }

    $img_name = $_FILES['img_file']['name'];
    $tmp_name = $_FILES['img_file']['tmp_name'];
    $img_path = $img_folder . basename($img_name);
    $thumb_path = $thumb_folder . basename($img_name);

    if (move_uploaded_file($tmp_name, $img_path)) {
        create_thumbnail($img_path, $thumb_path, 150);

        $sql = "INSERT INTO Imgs (img_title, img_description, img_name, img_path, img_alt, img_seo)
                VALUES ('$img_title', '$img_description', '$img_name', '$img_path', '$img_alt', '$img_seo')";

        if (mysqli_query($conn, $sql)) {
            header("Location: imgs.php");
            exit();
        } else {
            echo "Chyba při vkládání obrázku: " . mysqli_error($conn);
        }
    } else {
        echo "Chyba při nahrávání obrázku.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vytvořit nový obrázek</title>
</head>
<body>
    <h1>Vytvořit nový obrázek</h1>

    <form action="img_new.php" method="POST" enctype="multipart/form-data">
        <label for="img_title">Titulek:</label>
        <input type="text" name="img_title" required>
        <br>
        <label for="img_description">Popis:</label>
        <input type="text" name="img_description">
        <br>
        <label for="img_file">Soubor obrázku:</label>
        <input type="file" name="img_file" required>
        <br>
        <label for="img_alt">Alt:</label>
        <input type="text" name="img_alt">
        <br>
        <label for="img_seo">SEO:</label>
        <input type="text" name="img_seo">
        <br>
        <button type="submit" name="submit">Vytvořit</button>
    </form>

</body>
</html>
