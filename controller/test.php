<?php
namespace controller;
use extend\RESTful\restful;
class test
{
	function index()
	{
		$rst = new restful;
		$rst->send_init(200)->send("HEY!");
	}
	function useJson()
	{
		$rst = new restful;
		$arr = [
			'歌手'		=> 	"卢广仲",
			'歌曲'		=>	"我爱你",
		];
		$rst->send_init(200)->json($arr)->send();
	}
}
