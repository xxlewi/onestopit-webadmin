<!DOCTYPE html>
<html>
<head>
    <title>Připojení ke databázi</title>
</head>
<body>

<h1>Instalace WebAdmin</h1>
<h2>Připojení ke databázi</h2>

<form action="conn.php" method="POST">
    <label for="username">Uživatelské jméno:</label> <br>
    <input type="text" id="username" name="username"> <br>

    <label for="password">Heslo:</label> <br>
    <input type="password" id="password" name="password"> <br>

    <label for="page_name">Název nové stránky:</label> <br>
    <input type="text" id="dbname" name="dbname"> <br>

    <button type="submit" name="submit">Přihlásit se</button>
</form>

</body>
</html>
