<?php
class ProfileController
{
	public static $user;

	public static function defaultAction()
	{
		if (!Controller::isConnected())
		{
			header("Location: /Twitter/signin/");
			return 0;
		}
		Controller::renderAction("profile");
	}

	public static function editAction()
	{
		Controller::renderAction("editProfile");
	}

	public static function followersAction()
	{
		Controller::renderAction("followers");
	}

	public static function followingAction()
	{
		Controller::renderAction("following");
	}

	public static function getUserInfo()
	{
		self::$user = isset($_GET['action']) ? $_GET['action'] : $_SESSION['username'];
		if (isset($_GET['action']) && $_GET['action'] == "edit") {
			self::$user = $_SESSION['username'];
		}
		return ProfileModel::getUserInfo(self::$user);
	}

	public static function getUserTweets()
	{
		return ProfileModel::getUserTweets(self::$user);
	}

	public static function getFollowersAction()
	{
		ProfileModel::getFollowersAction();
	}

	public static function followAction()
	{
		ProfileModel::followAction();
	}

	public static function unFollowAction()
	{
		ProfileModel::unFollowAction();
	}

	public static function likeAction()
	{
		ProfileModel::likeAction();
	}

	public static function retweetAction()
	{
		ProfileModel::retweetAction();
	}

	public static function unLikeAction()
	{
		ProfileModel::likeAction();
	}
}