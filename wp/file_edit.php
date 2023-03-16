<?php
require_once 'head.php';

$file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;
$error = '';
$success = false;

if ($file_id <= 0) {
    die("Chyba: Neplatné ID souboru.");
}

$sql = "SELECT * FROM Files WHERE file_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $file_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Chyba: Soubor nebyl nalezen.");
}

$file = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $file_content = $_POST['file_content'];

    if (file_put_contents($file['file_path'], $file_content) === false) {
        $error = 'Chyba při ukládání souboru.';
    } else {
        $success = true;
    }
} else {
    $file_content = file_get_contents($file['file_path']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upravit soubor</title>
</head>
<body>
    <h1>Upravit soubor: <?php echo htmlspecialchars($file['file_name']); ?></h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green;">Soubor byl úspěšně uložen.</p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="file_content">Obsah souboru:</label><br>
        <textarea id="file_content" name="file_content" rows="10" cols="80" required><?php echo htmlspecialchars($file_content); ?></textarea><br>
        <button type="submit" name="submit">Uložit změny</button>
    </form>
</body>
</html>
