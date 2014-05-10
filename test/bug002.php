<?php

$data = array();

$tmp = &$data;
for ($i = 0; $i < 1024; $i++) {
    $tmp[] = array();
    $tmp = &$tmp[0];
}

$newdata = msgpack_unserialize(msgpack_serialize($data));
var_dump($newdata == $data);
?>