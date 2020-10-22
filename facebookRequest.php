<?php
	session_start();
	if($_POST){
		
		require_once("config.php");
		$conn = mysqli_connect($servername,$user,$password,$dbname);
		if($conn == false){
			echo 'ERROR';
			exit;
		}
		mysqli_set_charset($conn, 'utf8');

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

	    $firstName = $_POST['firstName'];
	    $lastName = $_POST['lastName'];
	    $email = $_POST['email'];
	    $firstName = mysqli_real_escape_string($conn,$firstName);
		$lastName = mysqli_real_escape_string($conn,$lastName);
		$email = mysqli_real_escape_string($conn,$email);

	    if($email == ""){
	    	echo "Email not provided";
	    	exit;
	    }

		if(emailExists($email,$conn) == true){
			$getNamesSql = 'SELECT id, firstName, lastName FROM users WHERE email = "' . $email . '" LIMIT 1';
			$getNamesQuery = mysqli_query($conn,$getNamesSql);
			if($row = mysqli_fetch_assoc($getNamesQuery)){
				$firstName = $row['firstName'];
				$lastName = $row['lastName'];
				$_SESSION['userId'] = $row['id'];
				echo "Success";
			}

			$_SESSION['isLogged'] = 1;
			if(strlen($firstName) > 13){
				$_SESSION['name'] = substr($firstName, 0, 10) . "...";
			}
			else{
				$_SESSION['name'] = $firstName;
			}
		}
		else{
			$mysql = 'INSERT INTO users (firstName, lastName, email, joined) VALUES ("' . $firstName . '","' . $lastName . '","' . $email . '", NOW())';
			$userJoin = mysqli_query($conn, $mysql);
			if($userJoin){
				$_SESSION['userId'] = mysqli_insert_id($conn);
			}
			else{
				echo 'Error';
				exit;
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