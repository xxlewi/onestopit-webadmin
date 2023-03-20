<?php
// require_once 'head.php';
require_once 'install/db_config.php';

$template_id = $_GET['template_id'] ?? 0;

if ($template_id == 0) {
    die('Neplatné ID šablony.');
} else {
    $sql = "SELECT * FROM Templates WHERE template_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $template_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $template = mysqli_fetch_assoc($result);
    } else {
        die('Šablona nebyla nalezena.');
    }
}

$template_file = $template['template_file'];


?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Náhled šablony</title>
    <link rel="stylesheet" href="../css/<?php echo $template['template_css']; ?>">
</head>
<body>
    <?php require_once "../templates/" . $template_file; ?>
</body>
</html>
