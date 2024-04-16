
<!DOCTYPE html>
<html>
<head>
    <title>Rezerwacja hotelu</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
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
            });
        });
    </script>
</head>
<body>
<h1>Formularz rezerwacji hotelu</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="num_of_guests">Ilość osób:</label>
    <select id="num_of_guests" name="num_of_guests">
        <option value="1" selected>1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <br>

    <div id="names">
        <label for="first_name1">Imię odoby 1:</label>
        <input type="text" id="first_name1" name="first_name1" required>
        <br>

        <label for="last_name1">Nazwisko osoby 1:</label>
        <input type="text" id="last_name1" name="last_name1" required>
        <br>
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

    <input type="submit" value="Wyślij">
</form>
<?php
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $liczba_osob = $_POST['num_of_guests'];

    if (empty($_POST["num_of_guests"])) {
        $error .= "Ilość osób jest wymagana.<br>";
    }

    for($i=1; $i<=$liczba_osob; $i++) {
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
        for($i=1; $i<=$liczba_osob; $i++){
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