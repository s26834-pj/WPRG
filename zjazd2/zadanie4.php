
<!DOCTYPE html>
<html>
<head>
    <title>Sprawdzenie liczby pierwszej</title>
</head>
<body>
<h2>Liczba pierwsza:</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Liczba: <input type="number" name="number" required><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
function isPrime($number) {
    if ($number <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($number); $i++) {
        global $iterations;
        $iterations++;
        if ($number % $i == 0) {
            return false;
        }
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST["number"];
    $iterations = 0;
    if (is_numeric($number) && $number > 0 && $number == round($number, 0)) {
        $isPrime = isPrime($number);
        echo "<p>Liczba $number ";
        if ($isPrime) {
            echo "jest liczbą pierwszą.</p>";
        } else {
            echo "nie jest liczbą pierwszą.</p>";
        }
        echo "<p>Liczba iteracji potrzebnych do wykonania obliczeń: $iterations</p>";
    } else {
        echo "<p>Błąd: podana wartość nie jest dodatnią liczbą całkowitą.</p>";
    }
}
?>
</body>
</html>