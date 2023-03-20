<?php
require_once './wp/install/db_config.php';

// Získání informací o šabloně z databáze
$sql = "SELECT * FROM Templates WHERE template_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $template_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $template_file = $row['template_file'];
    $template_txt_1 = $row['template_txt_1'];
    $template_txt_2 = $row['template_txt_2'];
    $template_txt_3 = $row['template_txt_3'];
    $template_txt_4 = $row['template_txt_4'];
    $template_txt_5 = $row['template_txt_5'];
} else {
    die("Šablona nebyla nalezena.");
}

// Získání obsahu textu a titulku pro každý text_id z databáze
function getTextInfo($conn, $text_id) {
    $sql = "SELECT text_title, text_content FROM Texts WHERE text_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $text_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

$txt_1 = getTextInfo($conn, $template_txt_1);
$txt_2 = getTextInfo($conn, $template_txt_2);
$txt_3 = getTextInfo($conn, $template_txt_3);
$txt_4 = getTextInfo($conn, $template_txt_4);
$txt_5 = getTextInfo($conn, $template_txt_5);




function getImageInfo($conn, $img_id) {
    $sql = "SELECT img_name, img_description, img_path FROM Imgs WHERE img_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $img_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

$img_1 = getImageInfo($conn, $row['template_img_1']);
$img_2 = getImageInfo($conn, $row['template_img_2']);
$img_3 = getImageInfo($conn, $row['template_img_3']);
$img_4 = getImageInfo($conn, $row['template_img_4']);
$img_5 = getImageInfo($conn, $row['template_img_5']);



?>
