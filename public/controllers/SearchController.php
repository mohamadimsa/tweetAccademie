<?php

class SearchController
{
	public static function defaultAction()
	{
		$user = isset($_GET['action']) ? $_GET['action'] : "";
		header("Location: /Twitter/profile/" . $user);
	}

	public static function searchAction()
	{
		SearchModel::searchAction();
	}
}