<?php

class Controller
{
	public static $countTweets;
	public static $countTags;

	public static function renderAction($page)
	{
		include 'views/' . $page . '.php';
	}

	public static function isConnected()
	{
		return null !== $_SESSION['username'] ? true : false;
	}

	public static function countTweetsAction()
	{
		return Model::countTweetsAction();
	}

	public static function countTagsAction()
	{
		return Model::countTagsAction();
	}

	public static function countFollowersAction()
	{
		return Model::countFollowersAction();
	}

	public static function countFollowingAction()
	{
		return Model::countFollowingAction();
	}

	public static function noResultAction()
	{
		self::renderAction("404");
	}

	public static function uploadAction()
	{
		Model::uploadAction();
	}
}