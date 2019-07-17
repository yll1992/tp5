<?php
namespace app\index\controller;


use think\Controller;


class ApiController extends Controller
{

	public function sms(){
		$sr=sendSms(17756503403,6666);
		var_dump($sr);
	}

}







