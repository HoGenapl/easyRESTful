<?php
namespace controller;
class index
{
    public function index()
    {
        echo "你好呀";
        var_dump($_GET);
    }
    public function sec()
    {
        echo "是你吗";
    }
}