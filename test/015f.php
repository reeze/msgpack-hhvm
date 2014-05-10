<?php
if(!extension_loaded('msgpack')) {
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

error_reporting(0);

$output = '';

function open($path, $name) {
    return true;
}

function close() {
    return true;
}

function read($id) {
    global $output;
    //broken data
    return pack('H*', '81a36');
}

function write($id, $data) {
    global $output;
    $output .= bin2hex($data). PHP_EOL;
    return true;
}

function destroy($id) {
    return true;
}

function gc($time) {
    return true;
}

ini_set('session.serialize_handler', 'msgpack');

session_set_save_handler('open', 'close', 'read', 'write', 'destroy', 'gc');

session_start();

echo ++$_SESSION['foo'], PHP_EOL;

session_write_close();

echo $output;
var_dump($_SESSION);
?>