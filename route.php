<?php
//*路由分发
//  /控制器/方法/参数/参数值/参数/参数值/.../.../

//初始化拓展
require __DIR__ . "\\extend\\init.php";
$url =  $_SERVER["REQUEST_URI"];
$seq = explode("/",$url);
$func = "index";                         //控制器方法
$cn = 0;                                 //GET偏移指针
if($seq[1] != "")                   
{
    //控制器真实存在
    $file_path = "controller\\" . $seq[1] . '.php';
    if(file_exists($file_path))
    {
        $class = $seq[1];               //控制器名字
        $cn++;
    }
}else
{
    $class = 'index';               //默认控制器
}              
$file_path = "controller\\" . $class . '.php';
if(file_exists($file_path))         //判断控制器是否存在
{
    include $file_path;             //引入控制器
    $con = new ReflectionClass("\\controller\\" . $class);
    if ($con->isInstantiable())     //如果可以实例化
    {
        
        if(isset($seq[2]))          //如果有设置第二参数(但此时仍不确定是否是函数名还是GET参数名)
        {
            if($con->hasMethod("$seq[2]"))      //如果存在该方法
            {
                $func = $seq[2];
                $cn++;
            }
        }
    }else
    {
        echo "error:not find Controller->Class 你的类名可能没对应";
        include "error.php";
        return -1;
    }
    set_get($seq,$cn);
    //echo "<br>";
    //var_dump($_GET);
    jump($class,$func);
}else
{
    include 'error.php';
}
//跳转到控制器
function jump($class,$method)
{
    $tem = '\\controller\\' . $class;
    if(class_exists($tem))
    {
        $func = new $tem;
        $func->$method();
    }else
    {
        include "error.php";
    }
}

//设置GET参数
//@param list $list [0]被舍弃,使用剩下的部分
//@param int start    起始位置
//@var
//ps:说实话,这个GET分配我自己的没摸太清楚.emm但就是可以实现效果了...=.=
function set_get($list,$start)
{
    $n = count($list);
    if($list[$n - 1] == "")
    {
      $n = $n - 2;
    }
    for($i = 1 + $start;$i<$n;$i += 2)
    {
        if(isset($list[$i]) && isset($list[$i + 1]))
        {
            $_GET[$list[$i]] = $list[$i + 1];
        }
    }
}




// function geturl($url){
//     //$headerArray =array("Content-type:application/json;","Accept:application/json");
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     //curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
//     $output = curl_exec($ch);
//     $out =  curl_getinfo($ch);
//     curl_close($ch);
//     $output = json_decode($output,true);
//     return $out;
// }
// $info = geturl("http://lazing.ltd");
// echo "<pre>";
// echo (json_encode($info));