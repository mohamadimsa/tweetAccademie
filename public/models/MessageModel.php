<?php

class MessageModel
{

	public static function getMessageAction()
	{
		$query = "SELECT content_message, date_message, 
					sender.username AS 'sender',
					receiver.username AS 'receiver'
					FROM message
					JOIN user sender ON id_sender = sender.id_user
					JOIN user receiver ON id_receiver = receiver.id_user
					WHERE (sender.username = ? AND receiver.username = ?)
					OR (receiver.username = ? AND sender.username = ?)
					ORDER BY date_message ASC";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_SESSION['username'], $_POST['username'],
						$_SESSION['username'], $_POST['username']]);
		echo json_encode([$req->fetchAll(PDO::FETCH_ASSOC)]);
		return 1;
	}
	public static function getUserMessagesAction()
	{
		$query = "SELECT id_sender, id_receiver, content_message, date_message, 
		sender.username as 'sender', receiver.username as 'receiver'
		FROM message
		JOIN user sender ON id_sender = sender.id_user
		JOIN user receiver ON id_receiver = receiver.id_user
		WHERE sender.username = ? OR receiver.username = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_SESSION['username'], $_SESSION['username']]);
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getUserContactAction()
	{
		$arr = [];
		$start = self::getUserMessagesAction();
		foreach ($start as $user) {
			if ($user['sender'] != $_SESSION['username']
				&& !in_array($user['sender'], $arr)) {
				$arr[] = $user['sender'];
			}
			if ($user['receiver'] != $_SESSION['username']
				&& !in_array($user['receiver'], $arr)) {
				$arr[] = $user['receiver'];
			}
		}
		return $arr;
	}

	public static function sendAction()
	{
		$query = "SELECT id_user FROM user WHERE username = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_POST['username']]);
		$id = $req->fetch(PDO::FETCH_ASSOC)['id_user'];

		if (!$id) {
			echo json_encode(["error" => "Invalid username"]);
			return 0;
		}

		$query = "INSERT INTO message (id_sender, id_receiver, content_message)
					VALUES (?, ?, ?)";
		$req = PDOConnection::prepareAction($query);
		if($req->execute([$_SESSION['id_user'],
						$id,
						$_POST['content']]))
		{
			echo json_encode(["ok" => "Message successfully sent."]);
			return 1;
		}
		echo json_encode(["error" => "An error has occured."]);
		return 0;
	}
}