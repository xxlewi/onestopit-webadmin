<?php 

require_once 'head.php';

$sql = "SELECT * FROM Imgs";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Obrázky</title>
</head>
<body>
    <h1>Seznam obrázků</h1>

    <a href="img_new.php">Vytvořit nový</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulek</th>
                <th>Popis</th>
                <th>Název</th>
                <th>Cesta</th>
                <th>Alt</th>
                <th>SEO</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['img_id']; ?></td>
                    <td><?php echo $row['img_title']; ?></td>
                    <td><?php echo $row['img_description']; ?></td>
                    <td><?php echo $row['img_name']; ?></td>
                    <td><?php echo $row['img_path']; ?></td>
                    <td><?php echo $row['img_alt']; ?></td>
                    <td><?php echo $row['img_seo']; ?></td>
                    <td>
                        <form action="img_delete.php" method="POST">
                            <input type="hidden" name="img_id" value="<?php echo $row['img_id']; ?>">
                            <button type="submit" name="delete">Smazat</button>
                        </form>
                    </td>
                    <td>
                        <form action="img_edit.php" method="POST">
                            <input type="hidden" name="img_id" value="<?php echo $row['img_id']; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</body>
</html>
