
<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator</title>
</head>

<body>

    <h1>Kalkulator </h1>
    <form method="post">
        <label for="Liczba">Podaj dwie liczby</label><br>
        <input type="text" id="LiczbaPierwsza" name="LiczbaPierwsza"><br>
        <input type="text" id="LiczbaDruga" name="LiczbaDruga"><br>
        <button id="Dodawnie" name="Dodawnie">Dodawnie</button>
        <button id="Odejmowanie" name="Odejmowanie">Odejmowanie</button>
        <button id="Dzielenie" name="Dzielenie">Dzielenie</button>
        <button id="Mnozenie" name="Mnozenie">Mnozenie</button>
    </form>
    <?php
        if (isset($_POST['LiczbaPierwsza'])) {
            $LiczbaPierwsza = $_POST['LiczbaPierwsza'];
        }
        if (isset($_POST['LiczbaDruga'])) {
            $LiczbaDruga = $_POST['LiczbaDruga'];
        }
        function dodaj($a, $b) {
            return $a + $b;
        }
        function Odejmij($a, $b) {
            return $a - $b;
        }
        function pomnoz($a, $b) {
            return $a * $b;
        }
        function podziel($a, $b) {
            return $a / $b;
        }
        
        if (isset($_POST['Dodawnie'])) {
            $wynik = dodaj($LiczbaPierwsza, $LiczbaDruga);
            echo "Wynik dodawania: " . $wynik;
        }
        if (isset($_POST['Odejmowanie'])) {
            $wynik = Odejmij($LiczbaPierwsza, $LiczbaDruga);
            echo "Wynik odejmowania: " . $wynik;
        }
        if (isset($_POST['Dzielenie'])) {
            $wynik = podziel($LiczbaPierwsza, $LiczbaDruga);
            echo "Wynik dzielenia: " . $wynik;
        }
        if (isset($_POST['Mnozenie'])) {
            $wynik = pomnoz($LiczbaPierwsza, $LiczbaDruga);
            echo "Wynik mnozenia: " . $wynik;
        }
    ?>

</body>

</html>