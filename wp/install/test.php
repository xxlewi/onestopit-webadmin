<?php
$config_file = 'db_config.php';

if (file_exists($config_file) && is_readable($config_file)) {
    include $config_file;

    if (!$conn) {
        die("Připojení selhalo: " . mysqli_connect_error());
    } else {
        echo "Připojení k databázi bylo úspěšné.";
    }
} else {
    die("Nelze načíst konfigurační soubor.");
}
?>
