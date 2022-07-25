<?php

class ProfileModel
{
	public static function getUserInfo($user)
	{
		$query = "SELECT * FROM user
					WHERE user.username = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([htmlspecialchars($user)]);
		return $req->fetch(PDO::FETCH_ASSOC);
	}

	public static function getFollowersAction()
	{
		$query = "SELECT username, avatar FROM user
					WHERE username LIKE ?
					LIMIT 15";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_POST['search']."%"]);
		// var_dump($req->fetchAll(PDO::FETCH_ASSOC));
		echo json_encode([$req->fetchAll(PDO::FETCH_ASSOC)]);
		// var_dump($_POST);
	}

	public static function followAction()
	{
		$query = "SELECT id_user FROM user
					WHERE username = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_POST['username']]);
		$id = $req->fetch(PDO::FETCH_ASSOC)['id_user'];

		$query = "SELECT status_follow FROM follow
					WHERE id_followed = ?
					AND id_follower = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$id, $_SESSION['id_user']]);
		if ($req->fetch()) {
			echo json_encode(["error" => "already following this person"]);
			return 0;
		}

		$query = "INSERT INTO follow (id_followed, id_follower)
					VALUES (?, ?)";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$id, $_SESSION['id_user']]);
	}

	public static function unFollowAction()
	{
		$query = "SELECT id_user FROM user
					WHERE username = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_POST['username']]);
		$id = $req->fetch(PDO::FETCH_ASSOC)['id_user'];

		$query = "UPDATE follow SET status_follow = 0
					WHERE id_followed = ?
					AND id_follower = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$id, $_SESSION['id_user']]);
	}

	public static function likeAction()
	{
		$query = "INSERT INTO likes (id_user, id_tweet)
					VALUES (?, ?)";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_SESSION['id_user'], $_POST['id_tweet']]);
	}

	public static function unLikeAction()
	{
		$query = "UPDATE likes SET status_like = 0
					WHERE id_user = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_SESSION['id_user']]);
	}

	public static function retweetAction()
	{
		$query = "INSERT INTO retweet (id_user, id_tweet, delete_retweet)
					VALUES (?, ?, 0)";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_SESSION['id_user'], $_POST['id_tweet']]);
	}

	public static function FollowersListAction()
	{	
		$query = "SELECT username, avatar FROM user LEFT JOIN follow ON follow.id_follower = user.id_user WHERE follow.id_followed = :id_user";

		$sql = PDOConnection::prepareAction($query);
		$sql->bindValue(":id_user", $_SESSION['id_user']);
		$sql->execute();
		return $sql->fetchAll();
	}

	public static function FollowingListAction()
	{
		$query = "SELECT username, avatar FROM user LEFT JOIN follow ON follow.id_followed = user.id_user WHERE follow.id_follower = :id_user";

		$sql = PDOConnection::prepareAction($query);
		$sql->bindValue(":id_user", $_SESSION['id_user']);
		$sql->execute();

		return $sql->fetchAll();
	}
}