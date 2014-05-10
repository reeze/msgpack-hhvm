<?php
$data = array('key' => 2, 1 => 3);

print_r(msgpack_unpack(msgpack_pack($data)));

$var = array( 1=> "foo", 2 => "bar");

$var[0] = "dummy";

print_r(msgpack_unpack(msgpack_pack($var)));

while ($v = current($var)) {
   var_dump($v);
   next($var);
}
?>