
<!DOCTYPE html>
<html>
<head>
    <title>data urodzenia</title>
</head>
<body>
<h1>data urodzenia</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <label>Podaj swoją datę urodzenia:</label>
    <input type="date" name="data_ur" required><br><br>
    <input type="submit" value="Wyślij">
</form>
<?php
if (isset($_GET['data_ur'])) {
    $data_ur = $_GET['data_ur'];
    $wiek = floor((time() - strtotime($data_ur)) / 31556926);
    $dzis = date('Y-m-d');
    $najblizsze_urodziny = date('Y-m-d', strtotime($data_ur . " +$wiek year"));
    $roznica = strtotime($najblizsze_urodziny) - strtotime($dzis);
    if ($roznica < 0) {
        $najblizsze_urodziny = date('Y-m-d', strtotime($data_ur . " +" . ($wiek+1) . " year"));
        $roznica = strtotime($najblizsze_urodziny) - strtotime($dzis);
    }
    $liczba_dni = round($roznica / (60 * 60 * 24));
    $dzien_tygodnia = date('l', strtotime($data_ur));

    echo "<h2>Twoja data urodzenia: $data_ur</h2>";
    echo "<h2>Twój wiek: $wiek lat</h2>";
    echo "<h2>Dzień tygodnia urodzenia: $dzien_tygodnia</h2>";
    echo "<h2>Liczba dni do następnych urodzin: $liczba_dni</h2>";
}
?>
</body>
</html>