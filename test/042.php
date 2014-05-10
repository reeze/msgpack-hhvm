<?php
if(!extension_loaded('msgpack')) {
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

$closure = function ($x) {
    return $x + 1;
};

class Foo implements Serializable {
    public function serialize() {
        echo "Should not be run.\n";
    }

    public function unserialize($str) {
        echo "Should not be run.\n";
    }
}

$array = array($closure, new Foo());

try {
    $ser = msgpack_serialize($array);
    echo "Serialized closure.\n";
    $unser = msgpack_unserialize($ser);
    echo "Unserialized closure.\n";
    var_dump($unser);
} catch (Exception $e) {
    echo "Got exception.\n";
}