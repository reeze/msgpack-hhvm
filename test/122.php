<?php
if(!extension_loaded('msgpack'))
{
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

//error_reporting(0);

function test($type, $variable, $object, $result = null)
{
    $msgpack = new MessagePack();
    $msgpack->setOption(MessagePack::OPT_PHPONLY, false);

    $serialized = $msgpack->pack($variable);

    $unserialized = $msgpack->unpack($serialized, $object);

    var_dump($unserialized);
    if ($result)
    {
        echo $unserialized == $result ? 'OK' : 'ERROR', PHP_EOL;
    }
    else
    {
        echo 'SKIP', PHP_EOL;
    }
}

class MyObj
{
    private $data = null;
    private $priv = "privdata";
    public  $pdata = null;
    public $subary = null;

    function __construct()
    {
        $this->data = "datadata";
        $this->subary = new SubObj();
    }
}

class SubObj
{
    private $subdata = null;
    private $subpriv = "subprivdata";
    public  $subpdata = null;

    function __construct()
    {
        $this->subdata = "subdatadata";
    }
}

$obj0 = new MyObj();
$obj0->pdata = "pubdata0";
$obj0->subary->subpdata = "subpubdata0";
$obj1 = new MyObj();
$obj1->pdata = "pubdata1";
$obj1->subary->subpdata = "subpubdata1";

$ary = array($obj0, $obj1);

$tpl = array(new MyObj());

test("recursive object list /w instance", $ary, $tpl, $ary);
