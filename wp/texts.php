<?php 

require_once 'head.php';

$sql = "SELECT * FROM Texts";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Texty</title>
</head>
<body>
    <h1>Seznam textů</h1>

    <a href="text_new.php">Vytvořit nový</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulek</th>
                <th>Obsah</th>
                <th>Typ</th>
                <th>Status</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['text_id']; ?></td>
                    <td><?php echo $row['text_title']; ?></td>
                    <td><?php echo $row['text_content']; ?></td>
                    <td><?php echo $row['text_type']; ?></td>
                    <td><?php echo $row['text_status']; ?></td>
                    <td>
                        <form action="text_delete.php" method="POST">
                            <input type="hidden" name="text_id" value="<?php echo $row['text_id']; ?>">
                            <button type="submit" name="delete">Smazat</button>
                        </form>
                    </td>
                    <td>
                        <form action="text_edit.php" method="POST">
                            <input type="hidden" name="text_id" value="<?php echo $row['text_id']; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</body>
</html>
