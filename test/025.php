<?php
if(!extension_loaded('msgpack')) {
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

function test($type, $variable, $test) {
    $serialized = msgpack_serialize($variable);
    $unserialized = msgpack_unserialize($serialized);

    var_dump($variable);
    var_dump($unserialized);
}

class Obj {
    public $a;
    protected $b;
    private $c;
    var $d;

    function __construct($a, $b, $c, $d) {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
    }

    function __sleep() {
        return array('a', 'b', 'c');
    }

#   function __wakeup() {
#       $this->d = $this->a + $this->b + $this->c;
#   }
}

$array = array(
    new Obj("aa", "bb", "cc", "dd"),
    new Obj("ee", "ff", "gg", "hh"),
    new Obj(1, 2, 3, 4),
);


test('array', $array, true);
?>