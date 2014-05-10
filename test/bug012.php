<?php

class Demo extends ArrayObject {

}

$obj = new StdClass();

$demo = new Demo;

$demo[] = $obj;
$demo[] = $obj;

$data = array(
    $demo,
    $obj,
    $obj,
);

print_r(msgpack_unserialize(msgpack_serialize($data)));
?>