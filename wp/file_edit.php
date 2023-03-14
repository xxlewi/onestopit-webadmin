<?php
session_start();
require_once 'install/db_config.php';

// zkontroluj, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// zobrazit formulář pro úpravu souboru
if (isset($_POST['edit'])) {
    $file_id = mysqli_real_escape_string($conn, $_POST['file_id']);
    $sql = "SELECT * FROM Files WHERE file_id='$file_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>
    <h2>Úprava souboru</h2>

    <form action="file_edit.php" method="POST">
        <input type="hidden" name="file_id" value="<?php echo $row['file_id']; ?>">
        <div>
            <label for="file_name">Název souboru:</label>
            <input type="text" id="file_name" name="file_name" value="<?php echo $row['file_name']; ?>">
        </div>
        <div>
            <label for="file_title">Titulek souboru:</label>
            <input type="text" id="file_title" name="file_title" value="<?php echo $row['file_title']; ?>">
        </div>
        <div>
            <label for="file_description">Popis souboru:</label>
            <textarea id="file_description" name="file_description"><?php echo $row['file_description']; ?></textarea>
        </div>
        <div>
            <label for="file_keywords">Klíčová slova souboru:</label>
            <input type="text" id="file_keywords" name="file_keywords" value="<?php echo $row['file_keywords']; ?>">
        </div>
        <div>
            <label for="file_status">Status souboru:</label>
            <select id="file_status" name="file_status">
                <option value="aktivní" <?php if ($row['file_status'] == 'aktivní') echo 'selected'; ?>>Aktivní</option>
                <option value="neaktivní" <?php if ($row['file_status'] == 'neaktivní') echo 'selected'; ?>>Neaktivní</option>
            </select>
        </div>
        <button type="submit" name="update">Uložit změny</button>
    </form>
<?php
    // uložit změny v souboru
if (isset($_POST['update'])) {
    $file_id = mysqli_real_escape_string($conn, $_POST['file_id']);
    $file_name = mysqli_real_escape_string($conn, $_POST['file_name']);
    $file_title = mysqli_real_escape_string($conn, $_POST['file_title']);
    $file_description = mysqli_real_escape_string($conn, $_POST['file_description']);
    $file_keywords = mysqli_real_escape_string($conn, $_POST['file_keywords']);
    $file_status = mysqli_real_escape_string($conn, $_POST['file_status']);

    $sql = "UPDATE Files SET 
            file_name='$file_name',
            file_title='$file_title',
            file_description='$file_description',
            file_keywords='$file_keywords',
            file_status='$file_status'
            WHERE file_id='$file_id'";
    mysqli_query($conn, $sql);

    header("Location: files.php");
    exit();
}
?>