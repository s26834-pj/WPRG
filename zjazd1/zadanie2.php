
<?php
function isPrimeNumber($number) {
    if ($number < 2) {
        return false;
    }
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return false;
        }
    }
    return true;
}

function printPrimeNumbers($start, $end) {
    for ($i = $start; $i <= $end; $i++) {
        if (isPrimeNumber($i)) {
            echo $i . "&nbsp;&nbsp;";
        }
    }
}
$start = 0;
$end = 50;
echo "Prime numbers in the range from $start to $end are: ";
printPrimeNumbers($start, $end);

?>
