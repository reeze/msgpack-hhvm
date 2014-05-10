<?php
if(!extension_loaded('msgpack')) {
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

function test($type, $variable, $test) {
    $serialized = msgpack_serialize($variable);
    $unserialized = msgpack_unserialize($serialized);

    echo $type, PHP_EOL;
    echo bin2hex($serialized), PHP_EOL;
    var_dump($unserialized);
    echo $test || $unserialized == $variable ? 'OK' : 'ERROR', PHP_EOL;
}

$a = array(
    'a' => array(
        'b' => 'c',
        'd' => 'e'
    ),
);

$a['f'] = &$a;

test('array', $a, true);

$a = array("foo" => &$b);
$b = array(1, 2, $a);
var_dump($a);
var_dump($k = msgpack_unserialize(msgpack_serialize($a)));

$k["foo"][1] = "b";
var_dump($k);
?>