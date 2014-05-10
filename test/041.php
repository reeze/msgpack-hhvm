<?php
function test($type, $variable) {
    $serialized = msgpack_serialize($variable);
    $unserialized = msgpack_unserialize($serialized);

    echo $type, PHP_EOL;
    var_dump($variable);
    var_dump($unserialized);

    echo bin2hex($serialized), PHP_EOL;
    echo PHP_EOL;
}

test('double NaN:', NAN);
test('double Inf:', INF);
test('double -Inf:', -INF);
test('double 0.0:', 0.0);
test('double -0.0:', -0.0);
