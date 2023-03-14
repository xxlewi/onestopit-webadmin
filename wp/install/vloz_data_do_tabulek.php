<?php
// připoj se k databázi
require_once 'db_config.php';



// kontrola, zda uživatel s daným jménem již existuje
$sql = "SELECT * FROM Users WHERE user_name='superadmin'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // uživatel již existuje, smazat ho
    $sql = "DELETE FROM Users WHERE user_name='superadmin'";
    if (mysqli_query($conn, $sql)) {
        echo "Uživatel byl úspěšně smazán<br>";
    } else {
        echo "Chyba při mazání uživatele: " . mysqli_error($conn) . "<br>";
    }
}

// vlož data do tabulky "Users" s novým heslem
$password = 'Borec1717';
$hash = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO Users (user_name, user_email, user_password, user_role) VALUES ('superadmin', 'mail@jirimaly.com', '$hash', 'superadmin')";

if (mysqli_query($conn, $sql)) {
    echo "Data byla úspěšně vložena do tabulky Users<br>";
} else {
    echo "Chyba při vkládání dat do tabulky Users: " . mysqli_error($conn) . "<br>";
}






// Vlož data do Files

$sql = "INSERT INTO Files (file_name, file_url, file_title, file_description, file_keywords, file_status)
        VALUES ('index.php', 'https://localhost/index.php', 'index', 'hlavní strana', 'None', 'aktivní')";

if (mysqli_query($conn, $sql)) {
    echo "Data úspěšně vložena do tabulky Files<br>";
} else {
    echo "Chyba při vkládání dat do tabulky Files: " . mysqli_error($conn) . "<br>";
}

// ukonči spojení s databází
mysqli_close($conn);
?>