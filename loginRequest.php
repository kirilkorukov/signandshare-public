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

		function userCheck($email, $inputPass, $conn){
			$getPassSql = 'SELECT password FROM users WHERE email="' . $email . '" LIMIT 1';
			$getPassQuery = mysqli_query($conn,$getPassSql);
			if($row = mysqli_fetch_assoc($getPassQuery)){
				$hashedPass = $row['password'];
			}

			if(crypt($inputPass,$hashedPass) == $hashedPass){
				return true;
			}
			else{
				return false;
			}
		}

	    $email = $_POST['emailLogin'];
	    $inputPass = $_POST['passwordLogin'];

		$email = mysqli_real_escape_string($conn,$email);
		$inputPass = mysqli_real_escape_string($conn,$inputPass);

		// Check if there is an empty field
		if($email == "" || $inputPass == ""){
			echo "Please fill out all fields.";
			exit;
		}

		// Check if the email is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  	echo "Invalid email address."; 
		  	exit;
		}

		if(emailExists($email,$conn) == true){
			if(userCheck($email, $inputPass, $conn) == true){
				$getNamesSql = 'SELECT id,firstName,lastName FROM users WHERE email="' . $email . '" LIMIT 1';
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
				echo 'The password and the email dont match';
			}
		}
		else{
			echo 'Email doesnt exists';
		}
	}
	else{
		echo "No post";
	}
?>