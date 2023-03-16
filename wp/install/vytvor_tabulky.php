<?php
// připoj se k databázi
require_once 'db_config.php';

// vytvoř tabulku "Files"
$sql = "CREATE TABLE Files (
    file_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(30) NOT NULL,
    file_path VARCHAR(100) NOT NULL,
    file_title VARCHAR(100) NOT NULL,
    file_description VARCHAR(255),
    file_keywords VARCHAR(255),
    file_status ENUM('active', 'inactive') DEFAULT 'active'
)";

if (mysqli_query($conn, $sql)) {
    echo "Tabulka Files byla úspěšně vytvořena<br>";
} else {
    echo "Chyba při vytváření tabulky Files: " . mysqli_error($conn) . "<br>";
}

// vytvoř tabulku "Templates"
$sql = "CREATE TABLE Templates (
    template_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_name VARCHAR(30) NOT NULL,
    template_file VARCHAR(30) NOT NULL,
    template_css VARCHAR(30),
    template_status ENUM('active', 'inactive') DEFAULT 'active',
    template_txt_1 VARCHAR(255),
    template_txt_2 VARCHAR(255),
    template_txt_3 VARCHAR(255),
    template_txt_4 VARCHAR(255),
    template_txt_5 VARCHAR(255),
    template_img_1 VARCHAR(255),
    template_img_2 VARCHAR(255),
    template_img_3 VARCHAR(255),
    template_img_4 VARCHAR(255),
    template_img_5 VARCHAR(255)
)";

if (mysqli_query($conn, $sql)) {
    echo "Tabulka Templates byla úspěšně vytvořena<br>";
} else {
    echo "Chyba při vytváření tabulky Templates: " . mysqli_error($conn) . "<br>";
}

// vytvoř tabulku "Text"
$sql = "CREATE TABLE Texts (
    text_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    text_title VARCHAR(100) NOT NULL,
    text_content LONGTEXT,
    text_type ENUM('article', 'caption', 'other') DEFAULT 'article'
    text_status VARCHAR(30)
)";

if (mysqli_query($conn, $sql)) {
    echo "Tabulka Text byla úspěšně vytvořena<br>";
} else {
    echo "Chyba při vytváření tabulky Text: " . mysqli_error($conn) . "<br>";
}

// vytvoř tabulku "Img"
$sql = "CREATE TABLE Imgs (
    img_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    img_title VARCHAR(100) NOT NULL,
    img_description VARCHAR(255),
    img_name VARCHAR(30) NOT NULL,
    img_path VARCHAR(255) NOT NULL,
    img_alt VARCHAR(255),
    img_seo VARCHAR(255)
)";

if (mysqli_query($conn, $sql)) {
    echo "Tabulka Img byla úspěšně vytvořena<br>";
} else {
    echo "Chyba při vytváření tabulky Img: " . mysqli_error($conn) . "<br>";
}

// vytvoř tabulku "Users"
$sql = "CREATE TABLE Users (
    user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(30) NOT NULL,
    user_email VARCHAR(50) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_role ENUM('admin', 'redactor', 'superadmin') DEFAULT 'redactor'
    )";
    
    if (mysqli_query($conn, $sql)) {
    echo "Tabulka Users byla úspěšně vytvořena<br>";
    } else {
    echo "Chyba při vytváření tabulky Users: " . mysqli_error($conn) . "<br>";
    }
    
    // ukonči spojení s databází
    mysqli_close($conn);
    ?>
