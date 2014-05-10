<?php
if(!extension_loaded('msgpack')) {
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

function test($type, $variable) {
    $unserialized = msgpack_unserialize(pack('H*', $variable));

    echo $type, PHP_EOL;
    echo $variable, PHP_EOL;
    var_dump($unserialized);
}

test('empty array:', '90');
test('array(1, 2, 3)', '93010203');
test('array(array(1, 2, 3), arr...', '93930102039304050693070809');
test('array("foo", "FOO", "Foo")', '93a3666f6fa3464f4fa3466f6f');
test('array(1, 123.45,  true, ...', '9701cb405edccccccccccdc3c293010293090807c0a3666f6f');
?>