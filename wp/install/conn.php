<?php
// zkontrolujeme, zda byl formulář odeslán
if (isset($_POST['submit'])) {

  // přihlašovací údaje k databázi
  $servername = "localhost";
  $username = $_POST['username'];
  $password = $_POST['password'];
  $dbname = str_replace(array(' ', ',', 'ě', 'š', 'č', 'ř', 'ž', 'ý', 'á', 'í', 'é', 'ú', 'ů', 'ď', 'ť', 'ň'), array('_', '', 'e', 's', 'c', 'r', 'z', 'y', 'a', 'i', 'e', 'u', 'u', 'd', 't', 'n'), $_POST['dbname']);
  $dbname = strtolower($dbname);

  var_dump($servername);
    var_dump($username);
    var_dump($password);
    var_dump($dbname);


  // připoj se k databázi
  $conn = mysqli_connect($servername, $username, $password);

  // zkontroluj připojení k databázi
  if (!$conn) {
    die("Připojení selhalo: " . mysqli_connect_error());
  }

  // zkontroluj, zda databáze již neexistuje
  $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 0) {
    // vytvoření nové databáze s názvem onestopit
    $sql = "CREATE DATABASE $dbname";
    if (mysqli_query($conn, $sql)) {
      echo "Databáze úspěšně vytvořena";
    } else {
      echo "Chyba při vytváření databáze: " . mysqli_error($conn);
    //   header("Location: install.php");
      exit();
    }
  }

  // vytvoř soubor db_config.php
  $file = fopen("db_config.php", "w") or die("Nelze vytvořit soubor!");
  $txt = "<?php\n";
  $txt .= "\$servername = '$servername';\n";
  $txt .= "\$username = '$username';\n";
  $txt .= "\$password = '$password';\n";
  $txt .= "\$dbname = '$dbname';\n";
  $txt .= "\$conn = mysqli_connect(\$servername, \$username, \$password, \$dbname);\n";
  $txt .= "?>";
  fwrite($file, $txt);
  fclose($file);

  // ukonči spojení s databází
  mysqli_close($conn);

  // přesměruj na stránku pro vytvoření tabulek
  header("Location: vytvor_tabulky.php");
  exit();
}
?>
