
<?php

function fib($n) {
    $fibonacci = array();
    $fibonacci[0] = 0;
    $fibonacci[1] = 1;

    for ($i = 2; $i < $n; $i++) {
        $fibonacci[$i] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
    }

    return $fibonacci;
}


$N = 20;

$fibonacci = fib($N);

echo "Elements of the Fibonacci up to N = $N:<br>";
$index = 1;
foreach ($fibonacci as $value) {
    if ($value % 2 != 0) {
        echo "$index. &nbsp; $value<br>"; 
        $index++;
    }
}

?>
