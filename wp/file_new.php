<?php
require_once 'head.php';

$error = '';
$success = false;

if (isset($_POST['submit'])) {
    $file_name = trim($_POST['file_name']);

    if (empty($file_name)) {
        $error = 'Název souboru nesmí být prázdný.';
    } else {
        // Odstraňte háčky a čárky
        $file_name_clean = preg_replace('/[^a-zA-Z0-9]+/', '_', $file_name);
        $file_path = '../' . $file_name_clean . '.php';
        $file_title = $file_name_clean;

        $sql_check = "SELECT * FROM Files WHERE file_name = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $file_name_clean);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = 'Název souboru již existuje. Zvolte jiný název.';
        } else {
            $sql = "INSERT INTO Files (file_name, file_path, file_title) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "sss", $file_name_clean, $file_path, $file_title);
            if (mysqli_stmt_execute($stmt)) {
                // Vytvořte soubor
                $file_content = "<?php\n// Toto je soubor $file_name_clean\n";

                if (file_put_contents($file_path, $file_content) === false) {
                    $error = 'Chyba při vytváření souboru.';
                } else {
                    $success = true;
                }
            } else {
                $error = "Chyba při vytváření souboru: " . mysqli_error($conn);
            }
        }
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Vytvořit soubor</title>
</head>
<body>
    <h1>Vytvořit soubor</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!$success): ?>
        <form action="" method="post">
            <label for="file_name">Název souboru:</label><br>
            <input type="text" id="file_name" name="file_name" required><br>
            <button type="submit" name="submit">Vytvořit soubor</button>
        </form>
        <?php else: ?>
        <p>Soubor byl úspěšně vytvořen.</p>
        <p>Název souboru: <?php echo $file_name_clean; ?></p>
        <p>Cesta k souboru: <?php echo $file_path; ?></p>
        <?php if ($success): ?>
    <form action="file_edit.php" method="get">
        <input type="hidden" name="file_id" value="<?php echo mysqli_insert_id($conn); ?>">
        <button type="submit">Upravit soubor</button>
    </form>
<?php endif; ?>

    <?php endif; ?>

</body>
</html>
