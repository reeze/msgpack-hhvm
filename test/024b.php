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

class Obj {
    public $a;
    protected $b;
    private $c;

    function __construct($a, $b, $c) {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
}

class Obj2 {
    public $aa;
    protected $bb;
    private $cc;
    private $obj;

    function __construct($a, $b, $c) {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;

        $this->obj = new Obj($a, $b, $c);
    }
}

class Obj3 {
    private $objs;

    function __construct($a, $b, $c) {
        $this->objs = array();

        for ($i = $a; $i < $c; $i += $b) {
            $this->objs[] = new Obj($a, $i, $c);
        }
    }
}

class Obj4 {
    private $a;
    private $obj;

    function __construct($a) {
        $this->a = $a;
    }

    public function set($obj) {
        $this->obj = $obj;
    }
}

$o2 = new Obj2(1, 2, 3);
test('objectrec', $o2, false);

$o3 = new Obj3(0, 1, 4);
test('objectrecarr', $o3, false);

$o4 = new Obj4(100);
$o4->set($o4);
test('objectselfrec', $o4, true);
?>