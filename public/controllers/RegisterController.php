<?php

class RegisterController
{
	public static function defaultAction()
	{
		Controller::renderAction("register");
	}
	
	public static function registerAction()
	{
		$register = new RegisterModel($_POST);
		$register->registerAction();
	}
}