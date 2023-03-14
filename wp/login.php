<?php
session_start();
require_once 'install/db_config.php';

// zkontrolujeme, zda byl formulář odeslán
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM Users WHERE user_name='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['user_password'])) {
            // uložíme uživatelská data do session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_role'] = $row['user_role'];

            // přesměrujeme na úvodní stránku aplikace
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Chybné heslo";
        }
    } else {
        $error_msg = "Uživatel neexistuje";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Přihlášení do WebAdmin Onestopit</title>
</head>
<body>
    <h1>Přihlášení do WebAdmin Onestopit</h1>
    <?php if (isset($error_msg)): ?>
        <p><?php echo $error_msg; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Uživatelské jméno:</label> <br>
        <input type="text" id="username" name="username"> <br>

        <label for="password">Heslo:</label> <br>
        <input type="password" id="password" name="password"> <br>

        <button type="submit" name="submit">Přihlásit se</button>
    </form>
</body>
</html>
