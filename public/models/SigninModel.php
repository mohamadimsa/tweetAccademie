<?php
class SigninModel
{	
	private $username;
	private $password;
	private $id_user;

	public function __construct(){
		
		if(isset($_POST["username"]) && isset($_POST["password"])){
			$this->username = $_POST["username"];
			$this->password = $_POST["password"];
		}
		elseif(!isset($_GET["username"]) || !isset($_GET["password"])) {
			echo json_encode(array("error"=>"Fields filled out incorrectly"));
			return 0;
		}
	}

	public function checkAccountAction(){
		$query = "SELECT * FROM user WHERE username LIKE :username";
		$sql = PDOConnection::prepareAction($query);
		$sql->bindParam(':username', $this->username);
		$sql->execute();
		$user = $sql->fetch();

		if(empty($user) || $user["status"]==0){
			return false;	
		}
		else {
			return true;
		}
	}

	public function checkPasswordAction(){
		if($this->checkAccountAction()){
			$query = "SELECT password FROM user WHERE username LIKE :username";
			$sql = PDOConnection::prepareAction($query);
			$sql->bindParam(':username', $this->username);
			$sql->execute();
			$db_password = $sql->fetch();

			$this->password .= "si tu aimes la wac tape dans tes mains";
			$hashed_input = hash('ripemd160', $this->password);

			if($hashed_input !== $db_password['password']){
				$alert = "Incorrect password/username combination";
				echo json_encode(array("error"=>"$alert"));
				return false;
			}
			else
				return true;
		}
		else {
			$alert = "This account does not exist";
			echo json_encode(array("error"=>"$alert"));
			return 0;
		}
	}

	public function signinAction(){
		if($this->checkPasswordAction()){
			Session::setSessionAction($this->username);
			echo json_encode(["Signin" => "ok"]);
			return 1;
		}
	}
}