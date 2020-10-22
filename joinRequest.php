<?php
	session_start();
	if(isset($_POST)){

		require_once("config.php");
		$conn = mysqli_connect($servername,$user,$password,$dbname);
		if($conn == false){
			echo 'ERROR';
			exit;
		}

		mysqli_set_charset($conn, 'utf8');

		function cryptPass($input, $rounds=9){
			$salt = "";
			$saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
			for($i=0; $i<22; $i++){
				$salt .= $saltChars[array_rand($saltChars)];
			}
			return crypt($input, sprintf('$2y$%02d$', $rounds).$salt);
		}

		function emailExists($email, $conn){
			$mysql = 'SELECT id FROM users WHERE email="' . $email . '" LIMIT 1';
			$checkEmailExisting = mysqli_query($conn, $mysql);
			if (mysqli_num_rows($checkEmailExisting)==0) {
				return false;
			}
			else{
				return true;
			}
		}

		$firstName = $_POST['firstNameJoin'];
	  $lastName = $_POST['lastNameJoin'];
	  $email = $_POST['emailJoin'];
	  $password = $_POST['passwordJoin'];

		$firstName = mysqli_real_escape_string($conn,$firstName);
		$lastName = mysqli_real_escape_string($conn,$lastName);
		$email = mysqli_real_escape_string($conn,$email);
		$password = mysqli_real_escape_string($conn,$password);

		// Check if there is an empty field
		if($firstName == "" || $lastName == "" || $email == "" || $password == ""){
			echo "Please fill out all fields.";
			exit;
		}

		// Check if the email is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  	echo "Invalid email address.";
		  	exit;
		}

		// Check if the email address exists
		if(emailExists($email,$conn) == true){
			echo 'This email address already exists.';
		}
		else if(strlen($password) < 6) {
			echo 'Your password must be at least 6 symbols.';
		}
		else{
			$hashedPass = cryptPass($password);
			$mysql = 'INSERT INTO users (firstName, lastName, email, password, joined) VALUES ("' . $firstName . '","' . $lastName . '","' . $email . '","' . $hashedPass . '", NOW())';
			$userJoin = mysqli_query($conn, $mysql);
			if($userJoin){
				$_SESSION['userId'] = mysqli_insert_id($conn);
			}
			else{
				echo 'Error';
				exit();
			}

			$_SESSION['isLogged'] = 1;
			if(strlen($firstName) > 13){
				$_SESSION['name'] = substr($firstName, 0, 10) . "...";
			}
			else{
				$_SESSION['name'] = $firstName;
			}

			echo "Success";
		}
	}

?>
