<?php

class PDOConnection
{
	protected $infos;
	public static $db;

	public function __construct(array $infos)
	{
		$this->infos = $infos;
		$this->ConnectAction();
	}

	public function ConnectAction()
	{
		if (self::$db == null)
		{
			$config = "mysql:dbname=" . $this->infos["dbname"] . ";host=" . $this->infos["host"];
			try
			{
			self::$db = new PDO($config, $this->infos["user"], $this->infos["pwd"]);
			}
			catch (PDOException $e)
			{
				print $e;
				die;
			}
		}
		else
		{
			return self::$db;
		}
	}

	public static function prepareAction($query)
	{
		$req = self::$db->prepare($query);
		return $req;
	}
}