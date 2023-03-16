<?php
require_once 'head.php';

$error = '';
$success = false;

if (isset($_POST['submit'])) {
    $template_name = trim($_POST['template_name']);

    if (empty($template_name)) {
        $error = 'Název šablony nesmí být prázdný.';
    } else {
        // Odstraňte háčky a čárky
        $template_name_clean = preg_replace('/[^a-zA-Z0-9]+/', '_', $template_name);
        $template_file = $template_name_clean . '.php';
        $template_css = $template_name_clean . '.css';

        $sql_check = "SELECT * FROM Templates WHERE template_name = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $template_name_clean);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = 'Název šablony již existuje. Zvolte jiný název.';
        } else {
            $sql = "INSERT INTO Templates (template_name, template_file, template_css) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "sss", $template_name_clean, $template_file, $template_css);
            if (mysqli_stmt_execute($stmt)) {
                // Vytvořte složky 'templates/' a 'css/' pokud neexistují
                if (!file_exists('templates')) {
                    mkdir('templates', 0755);
                }
                if (!file_exists('css')) {
                    mkdir('css', 0755);
                }

                // Vytvořte soubory šablony a CSS
                $template_file_path = 'templates/' . $template_file;
                $template_css_path = 'css/' . $template_css;

                $template_content = "<!-- Toto je šablona $template_name_clean -->\n";
                $css_content = "/* Toto je stylový soubor pro šablonu $template_name_clean */\n";

                if (file_put_contents($template_file_path, $template_content) === false || file_put_contents($template_css_path, $css_content) === false) {
                    $error = 'Chyba při vytváření souborů šablony a/nebo CSS.';
                } else {
                    $success = true;
                    $sql_id = "SELECT template_id FROM Templates WHERE template_name = ?";
$stmt_id = mysqli_prepare($conn, $sql_id);
mysqli_stmt_bind_param($stmt_id, "s", $template_name_clean);
mysqli_stmt_execute($stmt_id);
$result_id = mysqli_stmt_get_result($stmt_id);
$row_id = mysqli_fetch_assoc($result_id);
$template_id = $row_id['template_id'];
                }
            } else {
                $error = "Chyba při vytváření šablony: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vytvořit šablonu - krok 1</title>
</head>
<body>
    <h1>Vytvořit šablonu - krok 1</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!$success): ?>
        <form action="" method="post">
            <label for="template_name">Název šablony:</label><br>
            <input type="text" id="template_name" name="template_name" required><br>
            <button type="submit" name="submit">Vytvořit šablonu</button>
        </form>
    <?php else: ?>
        <p>Šablona byla úspěšně vytvořena.</p>
        <p>Název šablony: <?php echo $template_name_clean; ?></p>
        <p>Soubor šablony: <?php echo $template_file; ?></p>
        <p>Stylový soubor: <?php echo $template_css; ?></p>
        <form action="template_edit.php" method="POST">
    <input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
    <button type="submit" name="submit">Pokračovat na krok 2</button>
</form>
    <?php endif; ?>

</body>
</html>
