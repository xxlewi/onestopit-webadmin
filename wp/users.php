<?php 

require_once 'head.php';

$sql = "SELECT * FROM Users";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Uživatelé</title>
</head>
<body>
    <h1>Seznam uživatelů</h1>

    <a href="user_new.php">Vytvořit nový</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Jméno</th>
                <th>Email</th>
                <th>Role</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['user_email']; ?></td>
                    <td><?php echo $row['user_role']; ?></td>
                    <td>
                        <form action="user_delete.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <button type="submit" name="delete">Smazat</button>
                        </form>
                    </td>
                    <td>
                        <form action="user_edit.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</body>
</html>
