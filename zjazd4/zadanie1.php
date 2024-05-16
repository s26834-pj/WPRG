<?php
session_start();

$testLogin = "admin";
$testPassword = "admin";

if (isset($_POST['submit_login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if ($login === $testLogin && $password === $testPassword) {
        $_SESSION['isUserLoggedIn'] = true;
        setcookie("login", $login, time() + (60 * 60 * 24), "/");
    } else {
        echo '<p>Błędny login lub hasło. Spróbuj ponownie.</p>';
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezerwacja hotelu</title>
</head>
<body>
<?php if (!isset($_SESSION['isUserLoggedIn'])) : ?>
    <h1>Logowanie</h1>
    <form method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br><br>
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="submit_login" value="Zaloguj">
    </form>
<?php endif; ?>

<?php if (isset($_SESSION['isUserLoggedIn'])) : ?>
<?php if (isset($_COOKIE['login'])) : ?>
    <p>Witaj, <?php echo $_COOKIE['login']; ?>!</p>
<?php endif; ?>

<h1>Formularz rezerwacji hotelu</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="numbers">Ilość osób:</label>
    <label>
        <input type="number" name="numbers" value="<?php echo $_COOKIE["numbers"] ?? ''; ?>">
    </label>
    <br><br>
    <label for="name">Imię gościa:</label>
    <input type="text" id="name" name="name" value="<?php echo $_COOKIE["name"] ?? ''; ?>" required>
    <br><br>
    <label for="surname">Nazwisko gościa:</label>
    <input type="text" id="surname" name="surname" value="<?php echo $_COOKIE["surname"] ?? ''; ?>" required>
    <br><br>
    <label for="address">Adres:</label>
    <input type="text" id="address" name="address" value="<?php echo $_COOKIE["address"] ?? ''; ?>" required>
    <br><br>
    <label for="numCard">Numer karty kredytowej:</label>
    <input type="text" id="numCard" name="numCard" value="<?php echo $_COOKIE["numCard"] ?? ''; ?>" required>
    <br><br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo $_COOKIE["email"] ?? ''; ?>" required>
    <br><br>
    <label for="start_date">Data początku rezerwacji:</label>
    <input type="date" id="start_date" name="start_date" value="<?php echo $_COOKIE["start_date"] ?? ''; ?>" required>
    <br><br>
    <label for="end_date">Data końca rezerwacji:</label>
    <input type="date" id="end_date" name="end_date" value="<?php echo $_COOKIE["end_date"] ?? ''; ?>" required>
    <br><br>
    <label for="childBed">Dostawka dla dziecka:</label>
    <input type="checkbox" id="childBed" name="childBed" <?php if (isset($_COOKIE['childBed']) && $_COOKIE['childBed'] == 'Tak') echo 'checked'; ?>>
    <br><br>
    <label for="amenities">Udogodnienia:</label>
    <select id="amenities" name="amenities[]" multiple>
        <option value="klimatyzacja" >Klimatyzacja</option>
        <option value="tv">TV</option>
        <option value="wifi">WiFi</option>
        <option value="minibar">MiniBar</option>
    </select>
    <br><br>

    <button type="submit" name="submit" value="Zarezerwuj">Zarezerwuj</button>
    <button type="submit" name="clear_cookies" value="Wyczyść formularz" formnovalidate>Wyczyść formularz</button>
    <br><br>

    <?php
    if (isset($_POST["clear_cookies"])) {
        setcookie("numbers", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("name", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("surname", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("address", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("numCard", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("email", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("start_date", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("end_date", "", time() - (60 * 60 * 24 * 30), "/");
        setcookie("childBed", "", time() - (60 * 60 * 24 * 30), "/");
    }

    ?>
</form>
<form method="post">
    <input type="submit" name="logout" value="Wyloguj">
</form>
<div id="results"></div>
<?php else : ?>
    <p>Sesja wygasła, zaloguj się ponownie.</p>
<?php endif; ?>
<?php
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['submit'])) {

        $numbers = $_POST['numbers'];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $address = $_POST["address"];
        $numCard = $_POST["numCard"];
        $email = $_POST["email"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $childBed = isset($_POST["childBed"]) ? "Tak" : "Nie";
        $amenities = isset($_POST['amenities']) ? implode(', ', $_POST['amenities']) : '';

        setcookie("numbers", $numbers, time() + (60 * 60 * 24 * 30), "/");
        setcookie("name", $name, time() + (60 * 60 * 24 * 30), "/");
        setcookie("surname", $surname, time() + (60 * 60 * 24 * 30), "/");
        setcookie("address", $address, time() + (60 * 60 * 24 * 30), "/");
        setcookie("numCard", $numCard, time() + (60 * 60 * 24 * 30), "/");
        setcookie("email", $email, time() + (60 * 60 * 24 * 30), "/");
        setcookie("start_date", $start_date, time() + (60 * 60 * 24 * 30), "/");
        setcookie("end_date", $end_date, time() + (60 * 60 * 24 * 30), "/");
        setcookie("childBed", $childBed, time() + (60 * 60 * 24 * 30), "/");

        if (empty($_POST["numbers"])) {
            $error .= "Ilość osób jest wymagana.<br>";
        }

        if (empty($_POST["name"])) {
            $error .= "Imię jest wymagane.<br>";
        }

        if (empty($_POST["surname"])) {
            $error .= "Nazwisko jest wymagane.<br>";
        }

        if (empty($_POST["address"])) {
            $error .= "Adres jest wymagany.<br>";
        }

        if (empty($_POST["numCard"])) {
            $error .= "Numer karty kredytowej jest wymagany.<br>";
        }

        if (empty($_POST["email"])) {
            $error .= "E-mail jest wymagany.<br>";
        } else {
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error .= "Niepoprawny format e-maila.<br>";
            }
        }

        if (empty($_POST["start_date"]) || empty($_POST["end_date"])) {
            $error .= "Data pobytu jest wymagana.<br>";
        }

        $current_date = date('Y-m-d 00:00:00');
        if (strtotime($_POST["start_date"]) < strtotime($current_date)) {
            $error .= "Data początku rezerwacji nie może być wcześniejsza niż dzisiaj.<br>";
        }

        if (strtotime($_POST["end_date"]) < strtotime($_POST["start_date"]) && date('Y-m-d', strtotime($_POST["end_date"])) != date('Y-m-d', strtotime($_POST["start_date"]))) {
            $error .= "Data końca rezerwacji nie może być wcześniejsza niż początek rezerwacji.<br>";
        } elseif (strtotime($_POST["end_date"]) == strtotime($_POST["start_date"])) {
    
        } elseif (strtotime($_POST["end_date"]) > strtotime($_POST["start_date"])) {
     
        } else {
            $error .= "Nieprawidłowa data końca rezerwacji.<br>";
        }
      
        if ($error == "") {
            echo "<h2>Podsumowanie rezerwacji:</h2>";
            echo "<p>Ilość osób: " . $_POST["numbers"] . "</p>";
            echo "<p>Imię gościa: " . $_POST["name"] . "</p>";
            echo "<p>Nazwisko gościa: " . $_POST["surname"] . "</p>";
            echo "<p>Adres: " . $_POST["address"] . "</p>";
            echo "<p>Numer karty kredytowej: " . $_POST["numCard"] . "</p>";
            echo "<p>E-mail: " . $_POST["email"] . "</p>";
            echo "<p>Data początku rezerwacji: " . $_POST["start_date"] . "</p>";
            echo "<p>Data końca rezerwacji: " . $_POST["end_date"] . "</p>";
            if (isset($_POST["child_bed"])) {
                echo "<p>Dostawka dla dziecka: tak</p>";
            } else {
                echo "<p>Dostawka dla dziecka: nie</p>";
            }
            if (isset($_POST["amenities"])) {
                echo "<p>Udogodnienia: " . implode(", ", $_POST["amenities"]) . "</p>";
            } else {
                echo "<p>Udogodnienia: brak</p>";
            }
        } else {
            echo "<h2>Błędy:</h2>";
            echo "<p>$error</p>";
        }
    }
}
?>
</body>
</html>