<?php
class test {} 
print_r(msgpack_unserialize (msgpack_serialize (new test())));
?>