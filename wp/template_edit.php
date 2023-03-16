<?php

require_once 'head.php';

$template_id = $_POST['template_id'] ?? 0;
$error = '';
$template_name = '';
$template_file = '';
$template_css = '';

if ($template_id == 0) {
    $error = 'Neplatné ID šablony.';
} else {
    $sql = "SELECT * FROM Templates WHERE template_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $template_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $template_name = $row['template_name'];
        $template_file = $row['template_file'];
        $template_css = $row['template_css'];
    } else {
        $error = 'Šablona nebyla nalezena.';
    }
}

if (!empty($template_file) && !empty($template_css)) {
    $template_file_path = '../templates/' . $template_file;
    $template_css_path = '../css/' . $template_css;

    if (file_exists($template_file_path) && file_exists($template_css_path)) {
        $template_content = file_get_contents($template_file_path);
        $css_content = file_get_contents($template_css_path);
    } else {
        $error = 'Soubory šablony a/nebo CSS nebyly nalezeny.';
    }
}

// Uložení změn
if (isset($_POST['submit']) && !empty($template_file) && !empty($template_css)) {
    $template_content = $_POST['template_content'];
    $css_content = $_POST['css_content'];

    if (file_put_contents($template_file_path, $template_content) === false || file_put_contents($template_css_path, $css_content) === false) {
        $error = 'Chyba při ukládání změn.';
    } else {
        $success = 'Změny byly úspěšně uloženy.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upravit šablonu - <?php echo $template_name; ?></title>
</head>
<body>
    <h1>Upravit šablonu - <?php echo $template_name; ?></h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
        <label for="template_content">Obsah souboru šablony:</label><br>
        <textarea name="template_content" id="template_content" rows="10" cols="80"><?php echo htmlspecialchars($template_content); ?></textarea><br>
        <label for="css_content">Obsah souboru CSS:</label><br>
        <textarea name="css_content" id="css_content" rows="10" cols="80"><?php echo htmlspecialchars($css_content); ?></textarea><br>
        <button type="submit" name="submit">Uložit změny</button>
    </form>

</body>
</html>
