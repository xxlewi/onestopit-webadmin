<?php
require_once 'head.php';

if (isset($_POST['submit'])) {
    $template_id = $_POST['template_id'] ?? 0;
    $template_content = $_POST['template_content'];
    $css_content = $_POST['css_content'];

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
            $template_file = $row['template_file'];
            $template_css = $row['template_css'];
        } else {
            $error = 'Šablona nebyla nalezena.';
        }
    }

    if (!empty($template_file) && !empty($template_css)) {
        $template_file_path = 'templates/' . $template_file;
        $template_css_path = 'css/' . $template_css;

        if (file_put_contents($template_file_path, $template_content) !== false && file_put_contents($template_css_path, $css_content) !== false) {
            header('Location: templates.php?success=1');
            exit;
        } else {
            $error = 'Chyba při ukládání souborů šablony a/nebo CSS.';
        }
    }
}

header('Location: template_edit.php?error=' . urlencode($error));
exit;
