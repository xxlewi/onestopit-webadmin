<?php

require_once 'head.php';

if (isset($_POST['delete'])) {
    $template_id = mysqli_real_escape_string($conn, $_POST['template_id']);

    // Získání názvů souborů šablony a CSS
    $sql_get_filenames = "SELECT template_file, template_css FROM Templates WHERE template_id = $template_id";
    $result_get_filenames = mysqli_query($conn, $sql_get_filenames);

    if ($row = mysqli_fetch_assoc($result_get_filenames)) {
        // $template_file = $row['template_file'];
        // $template_css = $row['template_css'];

        // Smazání souborů šablony a CSS
        $templateFilePath = '../templates/' . $row['template_file'];
        $templateCssPath = '../css/' . $row['template_css'];


        if (file_exists($templateFilePath)) {
            unlink($templateFilePath);
        }
        
        if (file_exists($templateCssPath)) {
            unlink($templateCssPath);
        }

        // Smazání záznamu šablony z databáze
        $sql_delete_template = "DELETE FROM Templates WHERE template_id = $template_id";
        $result_delete_template = mysqli_query($conn, $sql_delete_template);

        if ($result_delete_template) {
            // Úspěšné smazání šablony
            header("Location: templates.php?delete=success");
            exit();
        } else {
            // Chyba při mazání šablony
            header("Location: templates.php?delete=error");
            exit();
        }
    } else {
        // Chyba při získávání informací o šabloně
        header("Location: templates.php?delete=notfound");
        exit();
    }
} else {
    // Přístup k souboru template_delete.php bez kliknutí na tlačítko Smazat
    header("Location: templates.php");
    exit();
}

?>
