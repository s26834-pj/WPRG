
<?php

$fruits = array("jablko", "banan", "pomarancza");

foreach ($fruits as $fruit) {
    $length = strlen($fruit);
    $reversedfruit = "";

    for ($i = $length - 1; $i >= 0; $i--) {
        $reversedfruit .= $fruit[$i];
    }

    if ($fruit[0] == "p" || $fruit[0] == "P") {
        $StartWithP = "It starting with p";
    } else {
        $StartWithP = "It doesn't start with p";
    }

    echo "Reversedfruit: ". $reversedfruit."&nbsp;&nbsp;&nbsp;&nbsp;". $StartWithP. "<br/>";
}
?>
