
<?php

$text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
galley of type and scrambled it to make a type specimen book. It has survived not only five
centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was
popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
and more recently with desktop publishing software like Aldus PageMaker including versions of
Lorem Ipsum.";

$words = explode(" ", $text);

foreach ($words as $key => $word) {
    $last_char = substr($word, -1);
    if (in_array($last_char, ['.', ',', ';', ':'])) {
        unset($words[$key]);
    }
}

$words = array_values($words);

$assoc_aray = array();
$count = count($words);
for ($i = 0; $i < $count; $i += 2) {
    if (isset($words[$i + 1])) {
        $assoc_aray[$words[$i]] = $words[$i + 1];
    }
}

foreach ($assoc_aray as $key => $value) {
    echo $key . " &nbsp;:&nbsp; " . $value . "</br>";
}
?>
