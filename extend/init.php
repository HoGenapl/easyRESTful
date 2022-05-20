<?php
//引入所有拓展文件
//文件名和拓展第一文件名要一致,例如:RESTful/ RESTful.php
$dir_l = dirname(__FILE__);
$dir_n = scandir($dir_l);
unset($dir_n[0]);           //去除 ./文件 
unset($dir_n[1]);           //去除 ../文件
foreach($dir_n as $v)
{
    if($v == "init.php") continue;      //去除init.php
    include $dir_l . "\\" . $v . "\\" . $v .".php";
}
