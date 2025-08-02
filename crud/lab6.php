<?php
function gcd($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

$n = (int)trim(fgets(STDIN));

if($n>6){
    die("Number should be less then 6");
}

$input = trim(fgets(STDIN));
$arr = array_map('intval', explode(' ', $input));

$gcds = [];
for ($i = 0; $i < $n; $i++) {
    for ($j = $i + 1; $j < $n; $j++) {
        $g = gcd($arr[$i], $arr[$j]);
        $gcds[] = $g;
    }
}

$gcds = array_unique($gcds);
sort($gcds);

print_r($gcds);

if (count($gcds) < 2) {
    echo "No second largest GCD here.\n";
} else {
    echo "Second largest GCD is: " . $gcds[count($gcds) - 2] . "\n";
}

?>
