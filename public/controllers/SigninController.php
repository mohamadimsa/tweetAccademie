<?php

class SigninController
{
	public static function defaultAction()
	{
		Controller::renderAction("signin");
	}

	public static function signinAction()
	{
		$signin = new SigninModel();
		$signin->signinAction();
	}
}