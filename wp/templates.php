<?php 

require_once 'head.php';

$sql = "SELECT * FROM Templates";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Šablony</title>
</head>
<body>
    <h1>Seznam šablon</h1>

    <a href="template_new.php">Vytvořit novou</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Název šablony</th>
                <th>Soubor šablony</th>
                <th>Stylový soubor</th>
                <th>Status</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['template_id']; ?></td>
                    <td><?php echo $row['template_name']; ?></td>
                    <td><?php echo $row['template_file']; ?></td>
                    <td><?php echo $row['template_css']; ?></td>
                    <td><?php echo $row['template_status']; ?></td>
                    <td><?php echo $row['template_txt_1']; ?></td>
                    <td><?php echo $row['template_txt_2']; ?></td>
                    <td><?php echo $row['template_txt_3']; ?></td>
                    <td><?php echo $row['template_txt_4']; ?></td>
                    <td><?php echo $row['template_txt_5']; ?></td>
                    <td><?php echo $row['template_img_1']; ?></td>
                    <td><?php echo $row['template_img_2']; ?></td>
                    <td><?php echo $row['template_img_3']; ?></td>
                    <td><?php echo $row['template_img_4']; ?></td>
                    <td><?php echo $row['template_img_5']; ?></td>
                    <td>
                    <form action="template_delete.php" method="POST">
                <input type="hidden" name="template_id" value="<?php echo $row['template_id']; ?>">
                <button type="submit" name="delete">Smazat</button>
            </form>
                    <td>
                        <form action="template_edit.php" method="POST">
                            <input type="hidden" name="template_id" value="<?php echo $row['template_id']; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</body>
</html>
