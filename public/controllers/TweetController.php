<?php

class TweetController
{
	public static function defaultAction()
	{
		
	}

	public static function getCommentsAction()
	{
		TweetModel::getCommentsAction();
	}

	public static function commentsAction()
	{
		include 'inc/comment.php';
	}

	public static function postCommentAction()
	{
		TweetModel::postCommentAction();
	}

	public static function getTweetAction()
	{
		TweetModel::getTweetAction();
	}

	public static function getLastTweetAction()
	{
		TweetModel::getLastTweetAction();
	}

	public static function postTweetAction()
	{
		TweetModel::postTweetAction();
	}

	public static function deleteTweetAction()
	{
		TweetModel::deleteTweetAction();
	}

	public static function delCommentAction()
	{
		TweetModel::delCommentAction();
	}
}