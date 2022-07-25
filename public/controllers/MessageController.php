<?php

class MessageController
{
	public static function defaultAction()
	{
		include 'inc/messages.php';
	}

	public static function sendAction()
	{
		MessageModel::sendAction();
	}

	public static function privateAction()
	{
		include 'inc/privateMessage.php';
	}

	public static function getMessageAction()
	{
		MessageModel::getMessageAction();
	}

	public static function getUserMessagesAction()
	{
		return MessageModel::getUserMessagesAction();
	}

	public static function getUserContactAction()
	{
		return MessageModel::getUserContactAction();
	}
}