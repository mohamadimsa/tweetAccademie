<?php

class AccountController
{
	public static function defaultAction()
	{
		
	}

	public static function registerAction()
	{
		$register = new RegisterModel($_POST);
		$register->registerAction();
	}

	public static function signinAction()
	{
		$signin = new SigninModel();
		$signin->signinAction();
	}
	
	public static function themeAction()
	{
		$theme = new AccountModel();
		$theme->ThemeAction();
	}
	
	public static function editAction()
	{
		$edit = new AccountModel();
		$edit->EditAction();
	}

	public static function delAccountAction()
	{
		AccountModel::delAccountAction();
	}
}