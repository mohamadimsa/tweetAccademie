<?php

class SearchModel
{
	public static function searchAction()
	{
		$query = "SELECT avatar, username FROM user
					WHERE username LIKE ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_POST['search'] . "%"]);
		$users = $req->fetchAll(PDO::FETCH_ASSOC);

		$query = "SELECT name_hashtag FROM hashtag
					WHERE name_hashtag LIKE ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_POST['search'] . "%"]);
		$tags = $req->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode([$users, $tags]);
		return 1;
	}
}