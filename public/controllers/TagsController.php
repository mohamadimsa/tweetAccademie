<?php

class TagsController
{
	public static function defaultAction()
	{
		if (!isset($_GET['action'])) {
			Controller::noResultAction();
			return 0;
		}
		Controller::renderAction("hashtags");
	}
}