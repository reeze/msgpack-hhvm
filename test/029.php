<?php 
ob_start();
phpinfo(INFO_MODULES);
$str = ob_get_clean();

$array = explode("\n", $str);

$section = false;
$blank = 0;
foreach ($array as $key => $val)
{
    if (strcmp($val, 'msgpack') == 0 || $section)
    {
        $section = true;
    }
    else
    {
        continue;
    }

    if (empty($val))
    {
        $blank++;
        if ($blank == 3)
        {
            $section = false;
        }
    }

    echo $val, PHP_EOL;
}