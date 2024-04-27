<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator silni i ciągu Fibonacciego</title>
</head>
<body>
<h1>Kalkulator silni i ciągu Fibonacciego</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="liczba">Wprowadź liczbę:</label>
    <input type="number" id="liczba" name="liczba" required>
    <button type="submit">Oblicz</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = $_POST['liczba'];
    function factorial_recursive($n) {
        if ($n <= 1) {
            return 1;
        }
        else {
            return $n * factorial_recursive($n-1);
        }
    }
    function fibonacci_recursive($n) {
        if ($n <= 1) {
            return $n;
        }
        else {
            return fibonacci_recursive($n-1) + fibonacci_recursive($n-2);
        }
    }
    function factorial_iterative($n) {
        $result = 1;
        for ($i = 2; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }
    function fibonacci_iterative($n) {
        if ($n == 0) {
            return 0;
        }
        else {
            $prev1 = 0;
            $prev2 = 1;
            for ($i = 2; $i <= $n; $i++) {
                $current = $prev1 + $prev2;
                $prev1 = $prev2;
                $prev2 = $current;
            }
            return $prev2;
        }
    }
    $start = microtime(true);
    $factorial_iter = factorial_iterative($n);
    $end = microtime(true);
    $time_factorial_iter = $end - $start;

    $start = microtime(true);
    $factorial_rec = factorial_recursive($n);
    $end = microtime(true);
    $time_factorial_rec = $end - $start;

    $start = microtime(true);
    $fibonacci_iter = fibonacci_iterative($n);
    $end = microtime(true);
    $time_fibonacci_iter = $end - $start;

    $start = microtime(true);
    $fibonacci_rec = fibonacci_recursive($n);
    $end = microtime(true);
    $time_fibonacci_rec = $end - $start;

    echo "<h2>Wyniki dla liczby $n:</h2>";
    echo "<p>Silnia iteracyjnie: $factorial_iter (czas: $time_factorial_iter s)</p>";
    echo "<p>Silnia rekurencyjnie: $factorial_rec (czas: $time_factorial_rec s)</p>";
    echo "<p>Ciąg Fibonacciego iteracyjnie: $fibonacci_iter (czas: $time_fibonacci_iter s)</p>";
    echo "<p>Ciąg Fibonacciego rekurencyjnie: $fibonacci_rec (czas: $time_fibonacci_rec s)</p>";
}
?>
</body>
</html>