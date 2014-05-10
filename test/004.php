<?php
if(!extension_loaded('msgpack')) {
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

function test($type, $variable) {
    $serialized = msgpack_serialize($variable);
    $unserialized = msgpack_unserialize($serialized);

    echo $type, PHP_EOL;
    echo bin2hex($serialized), PHP_EOL;
    var_dump($unserialized);
    echo $unserialized === $variable ? 'OK' : 'ERROR', PHP_EOL;
}

test('zero: 0', 0);
test('small: 1',  1);
test('small: -1',  -1);
test('medium: 1000', 1000);
test('medium: -1000', -1000);
test('large: 100000', 100000);
test('large: -100000', -100000);
?>