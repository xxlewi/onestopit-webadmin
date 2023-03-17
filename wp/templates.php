<?php 

require_once 'head.php';

$sql = "SELECT T.*, 
            tx1.text_title as text_title_1, tx2.text_title as text_title_2, tx3.text_title as text_title_3, tx4.text_title as text_title_4, tx5.text_title as text_title_5,
            img1.img_title as img_title_1, img2.img_title as img_title_2, img3.img_title as img_title_3, img4.img_title as img_title_4, img5.img_title as img_title_5
        FROM Templates AS T
        LEFT JOIN Texts AS tx1 ON T.template_txt_1 = tx1.text_id
        LEFT JOIN Texts AS tx2 ON T.template_txt_2 = tx2.text_id
        LEFT JOIN Texts AS tx3 ON T.template_txt_3 = tx3.text_id
        LEFT JOIN Texts AS tx4 ON T.template_txt_4 = tx4.text_id
        LEFT JOIN Texts AS tx5 ON T.template_txt_5 = tx5.text_id
        LEFT JOIN Imgs AS img1 ON T.template_img_1 = img1.img_id
        LEFT JOIN Imgs AS img2 ON T.template_img_2 = img2.img_id
        LEFT JOIN Imgs AS img3 ON T.template_img_3 = img3.img_id
        LEFT JOIN Imgs AS img4 ON T.template_img_4 = img4.img_id
        LEFT JOIN Imgs AS img5 ON T.template_img_5 = img5.img_id";
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
                <th>Text 1</th>
                <th>Text 2</th>
                <th>Text 3</th>
                <th>Text 4</th>
                <th>Text 5</th>
                <th>Obrázek 1</th>
                <th>Obrázek 2</th>
                <th>Obrázek 3</th>
                <th>Obrázek 4</th>
                <th>Obrázek 5</th>
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
                    <td><?php echo $row['text_title_1']; ?></td>
                    <td><?php echo $row['text_title_2']; ?></td>
                    <td><?php echo $row['text_title_3']; ?></td>
                    <td><?php echo $row['text_title_4']; ?></td>
                    <td><?php echo $row['text_title_5']; ?></td>
                    <td><?php echo $row['img_title_1']; ?></td>
                    <td><?php echo $row['img_title_2']; ?></td>
                    <td><?php echo $row['img_title_3']; ?></td>
                    <td><?php echo $row['img_title_4']; ?></td>
                    <td><?php echo $row['img_title_5']; ?></td>
                    <td>
                        <form action="template_delete.php" method="POST">
                            <input type="hidden" name="template_id" value="<?php echo $row['template_id']; ?>">
                            <button type="submit" name="delete">Smazat</button>
                        </form>
                    </td>
                    <td>
                        <form action="template_edit.php" method="get">
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
