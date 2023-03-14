<?php 

require_once 'head.php';

$sql = "SELECT * FROM Files";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Files</title>
</head>
<body>
    <h1>Seznam souborů</h1>

    <a href="file_new.php">Vytvořit nový</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Název</th>
                <th>Titulek</th>
                <th>Popis</th>
                <th>Klíčová slova</th>
                <th>Status</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['file_id']; ?></td>
                    <td><?php echo $row['file_name']; ?></td>
                    <td><?php echo $row['file_title']; ?></td>
                    <td><?php echo $row['file_description']; ?></td>
                    <td><?php echo $row['file_keywords']; ?></td>
                    <td><?php echo $row['file_status']; ?></td>
                    <td>
                        <form action="file_delete.php" method="POST">
                            <input type="hidden" name="file_id" value="<?php echo $row['file_id']; ?>">
                            <button type="submit" name="delete">Smazat</button>
                        </form>
                    </td>

                    <td>
                        <form action="file_edit.php" method="POST">
                            <input type="hidden" name="file_id" value="<?php echo $row['file_id']; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</body>
</html>
