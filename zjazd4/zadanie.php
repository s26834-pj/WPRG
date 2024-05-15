<?php
session_start();

// Ustawienia ciasteczek
$cookie_lifetime = 60 * 60 * 24 * 7; // 1 tydzień
$cookie_params = ["path" => "/", "httponly" => true, "secure" => false];

// Funkcja do zapisania ciasteczek
function save_form_data_to_cookies($data) {
    global $cookie_lifetime, $cookie_params;
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            setcookie($key, implode(",", $value), time() + $cookie_lifetime, $cookie_params["path"], "", $cookie_params["secure"], $cookie_params["httponly"]);
        } else {
            setcookie($key, $value, time() + $cookie_lifetime, $cookie_params["path"], "", $cookie_params["secure"], $cookie_params["httponly"]);
        }
    }
}

// Funkcja do czyszczenia ciasteczek
function clear_form_data_cookies() {
    global $cookie_params;
    foreach ($_COOKIE as $key => $value) {
        if (strpos($key, "first_name") !== false || strpos($key, "last_name") !== false || $key == "address" || $key == "credit_card" || $key == "email" || $key == "start_date" || $key == "end_date" || $key == "child_bed" || $key == "amenities" || $key == "num_of_guests") {
            setcookie($key, '', time() - 3600, $cookie_params["path"], "", $cookie_params["secure"], $cookie_params["httponly"]);
        }
    }
}

// Stałe dane logowania
$valid_username = "user";
$valid_password = "password";

// Logowanie użytkownika
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if ($username == $valid_username && $password == $valid_password) {
        $_SESSION["loggedin"] = true;
        setcookie("username", $username, time() + $cookie_lifetime, $cookie_params["path"], "", $cookie_params["secure"], $cookie_params["httponly"]);
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    } else {
        $login_error = "Nieprawidłowy login lub hasło.";
    }
}

// Wylogowanie użytkownika
if (isset($_GET["logout"])) {
    session_unset();
    session_destroy();
    setcookie("username", "", time() - 3600, $cookie_params["path"], "", $cookie_params["secure"], $cookie_params["httponly"]);
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

// Przechowywanie danych formularza w ciasteczkach
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_form"])) {
    save_form_data_to_cookies($_POST);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Rezerwacja hotelu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Ładowanie danych z ciasteczek do formularza
            <?php
            if (!empty($_COOKIE)) {
                foreach ($_COOKIE as $key => $value) {
                    if (strpos($key, "first_name") !== false || strpos($key, "last_name") !== false || $key == "address" || $key == "credit_card" || $key == "email" || $key == "start_date" || $key == "end_date") {
                        echo "$('#$key').val('" . addslashes($value) . "');\n";
                    }
                    if ($key == "child_bed" && $value == "on") {
                        echo "$('#child_bed').prop('checked', true);\n";
                    }
                    if ($key == "amenities") {
                        $amenities = explode(",", $value);
                        foreach ($amenities as $amenity) {
                            echo "$('#amenities option[value=\"$amenity\"]').prop('selected', true);\n";
                        }
                    }
                }
            }
            ?>

            $("#num_of_guests").change(function(){
                var num_of_guests = $(this).val();
                var html = "";
                for(var i=1; i<=num_of_guests; i++){
                    html += "<label for='first_name"+i+"'>Imię osoby "+i+":</label>";
                    html += "<input type='text' name='first_name"+i+"' id='first_name"+i+"' required>";
                    html += "<br>";
                    html += "<label for='last_name"+i+"'>Nazwisko osoby "+i+":</label>";
                    html += "<input type='text' name='last_name"+i+"' id='last_name"+i+"' required>";
                    html += "<br><br>";
                }
                $("#names").html(html);

                // Ładowanie dynamicznych danych z ciasteczek
                <?php
                if (!empty($_COOKIE)) {
                    foreach ($_COOKIE as $key => $value) {
                        if (strpos($key, "first_name") !== false || strpos($key, "last_name") !== false) {
                            echo "$('#$key').val('" . addslashes($value) . "');\n";
                        }
                    }
                }
                ?>
            });

            // Ładowanie liczby osób z ciasteczka i wywołanie zmiany
            <?php
            if (isset($_COOKIE["num_of_guests"])) {
                echo "$('#num_of_guests').val('" . $_COOKIE["num_of_guests"] . "').trigger('change');\n";
            }
            ?>
        });
    </script>
</head>
<body>
<h1>Rezerwacja hotelu</h1>

<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
    <p>Witaj, <?php echo htmlspecialchars($_COOKIE["username"]); ?>! <a href="?logout=1">Wyloguj się</a></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="num_of_guests">Ilość osób:</label>
        <select id="num_of_guests" name="num_of_guests">
            <option value="1" <?php if (isset($_COOKIE["num_of_guests"]) && $_COOKIE["num_of_guests"] == 1) echo "selected"; ?>>1</option>
            <option value="2" <?php if (isset($_COOKIE["num_of_guests"]) && $_COOKIE["num_of_guests"] == 2) echo "selected"; ?>>2</option>
            <option value="3" <?php if (isset($_COOKIE["num_of_guests"]) && $_COOKIE["num_of_guests"] == 3) echo "selected"; ?>>3</option>
            <option value="4" <?php if (isset($_COOKIE["num_of_guests"]) && $_COOKIE["num_of_guests"] == 4) echo "selected"; ?>>4</option>
        </select>
        <br>

        <div id="names">
            <!-- Pola imion i nazwisk generowane dynamicznie przez jQuery -->
        </div>

        <label for="address">Adres:</label>
        <input type="text" id="address" name="address" required>
        <br>

        <label for="credit_card">Numer karty kredytowej:</label>
        <input type="text" id="credit_card" name="credit_card" required>
        <br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>

        <label for="start_date">Data początku rezerwacji:</label>
        <input type="date" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>" required>
        <br>

        <label for="end_date">Data końca rezerwacji:</label>
        <input type="date" id="end_date" name="end_date" min="<?php echo date('Y-m-d'); ?>" required>
        <br>

        <label for="child_bed">Dostawka dla dziecka:</label>
        <input type="checkbox" id="child_bed" name="child_bed">
        <br>

        <label for="amenities">Udogodnienia:</label>
        <select id="amenities" name="amenities[]" multiple>
            <option value="klimatyzacja">Klimatyzacja</option>
            <option value="tv">TV</option>
            <option value="wifi">WiFi</option>
            <option value="minibar">MiniBar</option>
        </select>
        <br>

        <input type="submit" name="submit_form" value="Wyślij">
        <button type="submit" name="clear_cookies">Wyczyść formularz</button>
    </form>
<?php else: ?>
    <?php if (isset($login_error)): ?>
        <p style="color: red;"><?php echo $login_error; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Login:</label>
        <input type="text" id="username" name="username" required>
        <br>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <input type="submit" name="login" value="Zaloguj się">
    </form>
    <h3>Brak dostępu do formularza rezerwacji</h3>
    <p>Aby uzyskać dostęp do formularza rezerwacji, musisz się zalogować.</p>
<?php endif; ?>

<?php
// Obsługa czyszczenia ciasteczek formularza
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["clear_cookies"])) {
    clear_form_data_cookies();
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

// Obsługa walidacji i wyświetlania danych formularza
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_form"])) {
    $error = "";
    $liczba_osob = $_POST['num_of_guests'];

    if (empty($_POST["num_of_guests"])) {
        $error .= "Ilość osób jest wymagana.<br>";
    }

    for ($i = 1; $i <= $liczba_osob; $i++) {
        if (empty($_POST["first_name$i"])) {
            $error .= "Imię jest wymagane.<br>";
        }
        if (empty($_POST["last_name$i"])) {
            $error .= "Nazwisko jest wymagane.<br>";
        }
    }

    if (empty($_POST["address"])) {
        $error .= "Adres jest wymagany.<br>";
    }

    if (empty($_POST["credit_card"])) {
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
        echo "<p>Ilość osób: " . $_POST["num_of_guests"] . "</p>";
        for ($i = 1; $i <= $liczba_osob; $i++) {
            $imie = $_POST["first_name$i"];
            $nazwisko = $_POST["last_name$i"];
            echo "Imię osoby $i: $imie<br>";
            echo "Nazwisko osoby $i: $nazwisko<br>";
        }
        echo "<p>Adres: " . $_POST["address"] . "</p>";
        echo "<p>Numer karty kredytowej: " . $_POST["credit_card"] . "</p>";
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
?>
</body>
</html>
