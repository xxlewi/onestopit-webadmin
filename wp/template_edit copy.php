<?php
require_once 'head.php';

$template_id = $_GET['template_id'] ?? 0;
$error = '';
$success = '';

if ($template_id == 0) {
    $error = 'Neplatné ID šablony.';
} else {
    $sql = "SELECT * FROM Templates WHERE template_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $template_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $template = mysqli_fetch_assoc($result);
    } else {
        $error = 'Šablona nebyla nalezena.';
    }
}

if (isset($_POST['submit'])) {
    $template_name = $_POST['template_name'];
    $template_file = $_POST['template_file'];
    $template_css = $_POST['template_css'];
    $template_status = $_POST['template_status'];
    $template_txt_1 = $_POST['template_txt_1'];
    $template_txt_2 = $_POST['template_txt_2'];
    $template_txt_3 = $_POST['template_txt_3'];
    $template_txt_4 = $_POST['template_txt_4'];
    $template_txt_5 = $_POST['template_txt_5'];
    $template_img_1 = $_POST['template_img_1'];
    $template_img_2 = $_POST['template_img_2'];
    $template_img_3 = $_POST['template_img_3'];
    $template_img_4 = $_POST['template_img_4'];
    $template_img_5 = $_POST['template_img_5'];

    $sql_update = "UPDATE Templates SET template_name = ?, template_file = ?, template_css = ?, template_status = ?, template_txt_1 = ?, template_txt_2 = ?, template_txt_3 = ?, template_txt_4 = ?, template_txt_5 = ?, template_img_1 = ?, template_img_2 = ?, template_img_3 = ?, template_img_4 = ?, template_img_5 = ? WHERE template_id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssssssssssssssi", $template_name, $template_file, $template_css, $template_status, $template_txt_1, $template_txt_2, $template_txt_3, $template_txt_4, $template_txt_5, $template_img_1, $template_img_2, $template_img_3, $template_img_4, $template_img_5, $template_id);

    if (mysqli_stmt_execute($stmt_update)) {
        $success = 'Změny byly úspěšně uloženy.';

        // Znovu načíst data šablony z databáze po úspěšném uložení změn
        $sql = "SELECT * FROM Templates WHERE template_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $template_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $template = mysqli_fetch_assoc($result);
        } else {
            $error = 'Šablona nebyla nalezena.';
        }
    } else {
        $error = 'Chyba při ukládání změn: ' . mysqli_error($conn);
    }
}


// Načtení textů z databáze
$sql_texts = "SELECT * FROM Texts";
$result_texts = mysqli_query($conn, $sql_texts);
$texts = mysqli_fetch_all($result_texts, MYSQLI_ASSOC);

// Načtení obrázků z databáze
$sql_imgs = "SELECT * FROM Imgs";
$result_imgs = mysqli_query($conn, $sql_imgs);
$imgs = mysqli_fetch_all($result_imgs, MYSQLI_ASSOC);





?>

<!DOCTYPE html>
<html>
<head>
    <title>Upravit šablonu - <?php echo htmlspecialchars($template['template_name']); ?></title>
</head>
<body>
    <h1>Upravit šablonu - <?php echo htmlspecialchars($template['template_name']); ?></h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>



    <p><a href="template_edit_files.php?template_id=<?php echo $template_id; ?>">Upravit soubory šablony</a></p>


    <form action="" method="POST">
        <input type="hidden" name="template_id" value="<?php echo $template_id; ?>">

        <?php
        $fields = [
            'template_name' => 'Název šablony',
            'template_file' => 'Soubor šablony',
            'template_css' => 'Soubor CSS',
            'template_status' => 'Stav šablony',
            'template_txt_1' => 'Text 1',
            'template_txt_2' => 'Text 2',
            'template_txt_3' => 'Text 3',
            'template_txt_4' => 'Text 4',
            'template_txt_5' => 'Text 5',
            'template_img_1' => 'Obrázek 1',
            'template_img_2' => 'Obrázek 2',
            'template_img_3' => 'Obrázek 3',
            'template_img_4' => 'Obrázek 4',
            'template_img_5' => 'Obrázek 5',

            


        ];

        foreach ($fields as $field => $label) {
            if ($field === 'template_status') {
                ?>
                <label for="<?php echo $field; ?>"><?php echo $label; ?>:</label>
                <select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
                    <option value="active" <?php echo $template[$field] === 'active' ? 'selected' : ''; ?>>Aktivní</option>
                    <option value="inactive" <?php echo $template[$field] === 'inactive' ? 'selected' : ''; ?>>Neaktivní</option>
                </select><br>
                <?php
            } elseif (strpos($field, 'template_txt_') === 0) {
                // Pro textová pole
                ?>
                <label for="<?php echo $field; ?>"><?php echo $label; ?>:</label>
                <select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
                    <option value="">-- Vyberte text --</option>
                    <?php foreach ($texts as $text): ?>
                    <option value="<?php echo $text['text_id']; ?>" <?php echo $template[$field] == $text['text_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($text['text_title']); ?></option>
                    <?php endforeach; ?>
                </select><br>
                <?php
            } elseif (strpos($field, 'template_img_') === 0) {
                // Pro obrázky
                ?>
                <label for="<?php echo $field; ?>"><?php echo $label; ?>:</label>
                <select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
                    <option value="">-- Vyberte obrázek --</option>
                    <?php foreach ($imgs as $img): ?>
                    <option value="<?php echo $img['img_id']; ?>" <?php echo $template[$field] == $img['img_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($img['img_title']); ?></option>
                    <?php endforeach; ?>
                </select><br>
                <?php
            } else {
                ?>
                <label for="<?php echo $field; ?>"><?php echo $label; ?>:</label>
                <input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo htmlspecialchars($template[$field]); ?>"><br>
                <?php
            }
        }
        ?>

        <button type="submit" name="submit">Uložit změny</button>
    </form>

</body>
</html>
