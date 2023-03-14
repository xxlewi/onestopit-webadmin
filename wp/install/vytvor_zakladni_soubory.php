<?php
// Definujeme název souboru a jeho obsah
$filename = "../index.php";
$content = "Ahoj";

// Otevřeme soubor pro zápis
$file = fopen($filename, "w") or die("Nelze otevřít soubor pro zápis.");

// Zapíšeme obsah do souboru
fwrite($file, $content);

// Uzavřeme soubor
fclose($file);

// Zobrazíme zprávu o úspěchu
echo "Soubor $filename byl úspěšně vytvořen.";
?>
