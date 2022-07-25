<?php

class TweetModel
{
	public static function defaultAction()
	{
		
	}

	private static function getTweetCheck()
	{
		if (preg_match("/\/tags\//", $_SERVER['HTTP_REFERER'])) {
			self::getTweetFromTagAction();
			return 1;
		}
		if (preg_match("/\/mentions(\/)?/", $_SERVER['HTTP_REFERER'])) {
			self::getMentions();
			return 1;
		}
		if (preg_match("/\/profile(\/([a-zA-Z0-9]+))?/", $_SERVER['HTTP_REFERER'], $match)) {
			self::getUserTweets($match);
			return 1;
		}
	}
	public static function getTweetAction()
	{
		if (self::getTweetCheck())
			{
				return 1;
			}
		$query = "SELECT DISTINCT tweet.id_tweet, content_tweet, date_tweet, username, avatar
					FROM tweet
					JOIN user ON tweet.id_user = user.id_user
					LEFT JOIN follow 
					ON tweet.id_user = follow.id_followed
					LEFT JOIN retweet
					ON retweet.id_tweet = tweet.id_tweet
					WHERE delete_tweet = 0 
					AND ((follow.id_follower = :id_user
						AND follow.status_follow = 1) 
						OR tweet.id_user = :id_user
						OR retweet.id_user = :id_user)
					ORDER BY date_tweet DESC
					LIMIT :lim OFFSET :offset";
		$req = PDOConnection::prepareAction($query);
		$req->bindValue(":id_user", (int) $_SESSION['id_user'], PDO::PARAM_INT);
		$req->bindValue(":lim", (int) $_GET['limit'], PDO::PARAM_INT);
		$req->bindValue(":offset", (int) $_GET['offset'], PDO::PARAM_INT);
		$req->execute();
		$result = $req->fetchAll(PDO::FETCH_ASSOC);
		$result = self::checkTweetAction($result);
		echo json_encode(array_reverse($result));
		return 1;
	}

	private static function getLastTweetCheck()
	{
		if (preg_match("/\/tags\//", $_SERVER['HTTP_REFERER'])) {
			self::getLastTweetFromTagAction($_POST['id_tweet']);
			return 1;
		}
		if (preg_match("/\/mentions(\/)?/", $_SERVER['HTTP_REFERER'])) {
			self::getLastMentions($_POST['id_tweet']);
			return 1;
		}
		if (preg_match("/\/profile(\/([a-zA-Z0-9]+))?/", $_SERVER['HTTP_REFERER'], $match)) {
			self::getUserLastTweets($match, $_POST['id_tweet']);
			return 1;
		}
	}

	public static function getLastTweetAction()
	{
		if(self::getLastTweetCheck())
		{
			return 1;
		}
		$query = "SELECT DISTINCT id_tweet, content_tweet, date_tweet, username, avatar 
		FROM tweet
		JOIN user ON tweet.id_user = user.id_user
		LEFT JOIN follow 
		ON tweet.id_user = follow.id_followed
		LEFT JOIN retweet
		ON retweet.id_tweet = tweet.id_tweet
		WHERE tweet.id_tweet > ?
		AND delete_tweet = 0 
			AND ((follow.id_follower = :id_user
			AND follow.status_follow = 1) 
			OR tweet.id_user = :id_user
			OR retweet.id_user = :id_user)
		ORDER BY date_tweet DESC";
		$req = PDOConnection::prepareAction($query);
		$req->execute([htmlspecialchars($_POST['id_tweet']),
						$_SESSION['id_user'],
						$_SESSION['id_user']]);
		$result = $req->fetchAll(PDO::FETCH_ASSOC);
		$result = self::checkTweetAction($result);
		echo json_encode($result);
		return 1;
	}

	public static function postTweetAction()
	{
		if (strlen($_POST['content']) > 140) {
			echo json_encode(["error" => "Le tweet ne doit pas exceder 140 caracteres."]);
			return 0;
		}
		$query = "INSERT INTO tweet (id_user, content_tweet, delete_tweet)
		VALUES (:id_user, :content_tweet, :delete_tweet)";
		$req = PDOConnection::prepareAction($query);
		$req->execute(array(
			':id_user' => htmlspecialchars($_SESSION['id_user']),
			':content_tweet' => htmlspecialchars($_POST['content']),
			':delete_tweet' => 0));
		self::insertTagsAction($_POST['content']);
		echo json_encode(["PostTweet" => "ok"]);
		return 1;
	}

	private static function checkTweetAction($tweets)
	{
		$tweets = self::checkImage($tweets);
		foreach ($tweets as $k => $tweet) {
			preg_match_all("/#([a-zA-Z0-9]+)/", $tweet['content_tweet'], $matches);
			foreach ($matches[0] as $key => $tag) {
				$replace = "<a href=\"/Twitter/tags/".$matches[1][$key]."\">$tag</a>";
				$tweet['content_tweet'] = str_replace($tag, $replace, $tweet['content_tweet']);
			}
			$tweets[$k] = $tweet;
		}
		foreach ($tweets as $k => $tweet) {
			preg_match_all("/@([a-zA-Z0-9]+)/", $tweet['content_tweet'], $matches);
			foreach ($matches[0] as $key => $mention) {
				$replace = "<a href=\"/Twitter/profile/".$matches[1][$key]."\">$mention</a>";
				$tweet['content_tweet'] = str_replace($mention, $replace, $tweet['content_tweet']);
			}
			$tweets[$k] = $tweet;
		}
		return $tweets;
	}

	private static function checkImage($tweets)
	{
		foreach ($tweets as $k => $tweet) {
			preg_match_all("/~([a-zA-Z0-9]{4})/", $tweet['content_tweet'], $m);
			if (!empty($m[0])) {
				foreach ($m[0] as $key => $img) {
					$ext = is_file("/Twitter/public/upload/".$m[1][$key].".png") ? ".png" : ".jpg";
					$replace = "<p><img src=\"/Twitter/public/upload/".$m[1][$key].$ext."\"></p>";
					$tweet['content_tweet'] = str_replace($m[0][$key], $replace, $tweet['content_tweet']);
				}
			}
			$tweets[$k] = $tweet;
		}
		return $tweets;
	}

	private static function insertTagsAction($content)
	{
		$query = "SELECT id_tweet FROM tweet WHERE id_user = ?
		ORDER BY date_tweet DESC LIMIT 1";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_SESSION['id_user']]);
		$id_tweet = $req->fetch(PDO::FETCH_ASSOC)['id_tweet'];

		preg_match_all("/#([a-zA-Z]+)/", $content, $matches);
		foreach ($matches[1] as $match) {
			$query = "SELECT * FROM hashtag WHERE name_hashtag = ?";
			$req = PDOConnection::prepareAction($query);
			$req->execute([$match]);
			if(!$req->fetchAll(PDO::FETCH_ASSOC)) {
				$query = "INSERT INTO hashtag (name_hashtag) VALUES (?)";
				$req = PDOConnection::prepareAction($query);
				$req->execute([htmlspecialchars($match)]);
			}
			self::tweetToTagAction($match, $id_tweet);
		}
	}

	private static function tweetToTagAction($match, $id_tweet)
	{
		$query = "SELECT id_hashtag FROM hashtag WHERE name_hashtag = ?";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$match]);
		$id_hashtag = $req->fetch(PDO::FETCH_ASSOC)['id_hashtag'];

		$query = "INSERT INTO tweet_to_tag (id_tweet, id_tag) VALUES (?, ?)";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$id_tweet, $id_hashtag]);
	}

	private static function getTweetFromTagAction()
	{
		$query = "SELECT tweet.id_tweet, content_tweet, date_tweet, username, avatar 
		FROM tweet
		JOIN tweet_to_tag ON tweet.id_tweet = tweet_to_tag.id_tweet
		JOIN hashtag ON tweet_to_tag.id_tag = hashtag.id_hashtag
		JOIN user ON tweet.id_user = user.id_user
		WHERE hashtag.name_hashtag = ?
		ORDER BY date_tweet ASC";
		preg_match("/\/tags\/([a-zA-Z0-9]+)/", $_SERVER['HTTP_REFERER'], $match);
		$req = PDOConnection::prepareAction($query);
		$req->execute([$match[1]]);
		$result = $req->fetchAll(PDO::FETCH_ASSOC);
		$result = self::checkTweetAction($result);
		echo json_encode($result);
		return 1;
	}

	private static function getLastTweetFromTagAction($id)
	{
		$query = "SELECT tweet.id_tweet, content_tweet, date_tweet, username, avatar 
		FROM tweet
		JOIN tweet_to_tag ON tweet.id_tweet = tweet_to_tag.id_tweet
		JOIN hashtag ON tweet_to_tag.id_tag = hashtag.id_hashtag
		JOIN user ON tweet.id_user = user.id_user
		WHERE hashtag.name_hashtag = ?
		AND tweet.id_tweet > ?
		AND delete_tweet = 0
		ORDER BY date_tweet DESC";
		preg_match("/\/tags\/([a-zA-Z0-9]+)/", $_SERVER['HTTP_REFERER'], $match);
		$req = PDOConnection::prepareAction($query);
		$req->execute([$match[1], $id]);
		$result = $req->fetchAll(PDO::FETCH_ASSOC);
		$result = self::checkTweetAction($result);
		echo json_encode($result);
		return 1;
	}

	public static function getUserTweets($match)
	{
		if ($match[0] == "/profile" || $match[0] == "/profile/") {
			$user = $_SESSION['username'];
		}
		else {
			$user = $match[2];
		}
		$query = "SELECT id_tweet, content_tweet, date_tweet, username, avatar
		FROM tweet
		JOIN user ON tweet.id_user = user.id_user
		WHERE user.username = ?
		AND delete_tweet = 0
		ORDER BY date_tweet ASC";
		$req = PDOConnection::prepareAction($query);
		$req->execute([htmlspecialchars($user)]);
		$result = $req->fetchAll(PDO::FETCH_ASSOC);
		$result = self::checkTweetAction($result);
		echo json_encode($result);
	}

	public static function getUserLastTweets($match, $id)
	{
		if ($match[0] == "/profile" || $match[0] == "/profile/") {
			$user = $_SESSION['username'];
		}
		else {
			$user = $match[2];
		}
		$query = "SELECT id_tweet, content_tweet, date_tweet, username, avatar
		FROM tweet
		JOIN user ON tweet.id_user = user.id_user
		WHERE user.username = ?
		AND tweet.id_tweet > ?
		AND delete_tweet = 0
		ORDER BY date_tweet DESC";
		$req = PDOConnection::prepareAction($query);
		$req->execute([htmlspecialchars($user), $id]);
		$result = $req->fetchAll(PDO::FETCH_ASSOC);
		$result = self::checkTweetAction($result);
		echo json_encode($result);
	}

	private static function getMentions()
	{
		$query = "SELECT id_tweet, content_tweet, date_tweet, username, avatar 
		FROM tweet
		JOIN user ON tweet.id_user = user.id_user 
		WHERE content_tweet LIKE :username
		AND delete_tweet = 0
		ORDER BY date_tweet ASC";
		$sql = PDOConnection::prepareAction($query);
		$sql->bindValue(":username", "%@".$_SESSION['username']."%");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		$res = self::checkTweetAction($res);
		echo json_encode($res);
	}

	private static function getLastMentions($id)
	{
		$query = "SELECT id_tweet, content_tweet, date_tweet, username, avatar 
		FROM tweet
		JOIN user ON tweet.id_user = user.id_user 
		WHERE content_tweet LIKE :username 
		AND tweet.id_tweet > :last
		AND delete_tweet = 0
		ORDER BY date_tweet DESC";
		$sql = PDOConnection::prepareAction($query);
		$sql->bindValue(":username", "%@".$_SESSION['username']."%");
		$sql->bindValue(":last", $id);
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		$res = self::checkTweetAction($res);
		echo json_encode($res);
	}

	public static function getCommentsAction()
	{
		$query = "SELECT *, username FROM comment
				JOIN user
				ON comment.id_user = user.id_user
				WHERE id_tweet = ?
				AND delete_comment = 0
				ORDER BY date_comment ASC";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_GET['idTweet']]);
		echo json_encode([$req->fetchAll(PDO::FETCH_ASSOC)]);
		return 1;
	}

	public static function postCommentAction()
	{
		$query = "INSERT INTO comment
					(id_user, id_tweet, content_comment)
					VALUES
					(?, ?, ?)";
		$req = PDOConnection::prepareAction($query);
		$req->execute([$_SESSION['id_user'], $_POST['idTweet'],
			htmlspecialchars($_POST['content'])]);
		echo json_encode(["ok" => $_SESSION['username']]);
		return 1;
	}

	public static function deleteTweetAction()
	{
		$query = "UPDATE tweet SET delete_tweet = 1
					WHERE id_tweet = ?
					AND id_user = ?";
		$req = PDOConnection::prepareAction($query);
		if ($req->execute([$_POST['idTweet'], $_SESSION['id_user']])) {
			echo json_encode(["ok" => "deleted"]);
		} else {
			echo json_encode(["error" => "bad account"]);
		}
		return 1;
	}

	public static function delCommentAction()
	{
		$query = "UPDATE comment SET delete_comment = 1
					WHERE id_comment = ?
					AND id_user = ?";
		$req = PDOConnection::prepareAction($query);
		if ($req->execute([$_POST['idComment'], $_SESSION['id_user']])) {
			echo json_encode(["ok" => "deleted"]);
		} else {
			echo json_encode(["error" => "bad account"]);
		}
		return 1;
	}
}