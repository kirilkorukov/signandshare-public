<?php
		session_start();

		require_once("config.php");
    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    if(!isset($_SESSION['isLogged'])){
    	echo "Not logged in";
    	exit;
    }

    $userId = $_SESSION['userId'];
    $currDate = date("Y-m-d");
    $getStarterName = 'SELECT firstName, lastName from users WHERE id = ' . $userId;
	  $getStarterNameQuery = mysqli_query($conn, $getStarterName);
	  if($row = mysqli_fetch_assoc($getStarterNameQuery)){
			$starter = $row['firstName'] . " " . $row['lastName']; // error
		}

		if($_POST){
			$title = $_POST['title'];
			$target = mysqli_real_escape_string($conn, $_POST['target']);
			$overview = mysqli_real_escape_string($conn, $_POST['description']);
			$category = mysqli_real_escape_string($conn, $_POST['category']);

			if($title == "" || $target == "" || $overview == ""){
				echo "Please fill out all fields.";
				exit;
			}

			$newTitle = htmlentities($title);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$path = str_replace(' ', '-', $newTitle); // Replaces all spaces with hyphens.
	   	$path = preg_replace('/[^A-Za-z0-9\-]/', '', $path); // Removes special chars.

	   	$path = preg_replace('/-+/', '-', $path); // Replaces multiple hyphens with single one.
	   	$path =  strtolower(trim($path,'-'));

			$imagePath = uniqid() . uniqid();

			if($path == ""){
				$path = $imagePath;
			}

			if (!file_exists('p/' . $path)) {
			    mkdir('p/' . $path, 0777, true);
			    // A folder for the petition has been created

	        $uploaddir = 'images/petitions/';
	        $_FILES['imageUpload']['name'] = $imagePath . ".jpg";
	        $uploadfile = $uploaddir . basename($_FILES['imageUpload']['name']);
	        if(move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadfile)){
		            $createPetition = 'INSERT INTO petition (title, byWho, target, currentSupporters, goalSupporters, date, overview, image, category, user_id, path) VALUES ("' . $title . '", "' . $starter . '", "' . $target . '", 0, 100, "' . $currDate . '", "' . $overview . '", "' . $imagePath . '.jpg", "' . $category . '", ' . $userId . ', "' . $path . '")';
				  $createPetitionQuery = mysqli_query($conn, $createPetition);
				}
				else{
				    $createPetition = 'INSERT INTO petition (title, byWho, target, currentSupporters, goalSupporters, date, overview, category, user_id, path) VALUES ("' . $title . '", "' . $starter . '", "' . $target . '", 0, 100, "' . $currDate . '", "' . $overview . '", "' . $category . '", ' . $userId . ', "' . $path . '")';
			    	$createPetitionQuery = mysqli_query($conn, $createPetition);
	      }

			    if($createPetitionQuery){
			    	$petitionId = mysqli_insert_id($conn);
			    	copy('petition-files/index.php', 'p/' . $path . '/index.php');
				    copy('petition-files/petitionId.php', 'p/' . $path . '/petitionId.php');
				    copy('petition-files/declare_victory.php', 'p/' . $path . '/declare_victory.php');
				    copy('petition-files/close_petition.php', 'p/' . $path . '/close_petition.php');
				    copy('petition-files/just_signed.php', 'p/' . $path . '/just_signed.php');
				    copy('petition-files/edit.php', 'p/' . $path . '/edit.php');
				    copy('petition-files/editRequest.php', 'p/' . $path . '/editRequest.php');
				    copy('petition-files/petitionId.php', 'p/' . $path . '/petitionId.php');
				    copy('petition-files/post_update.php', 'p/' . $path . '/post_update.php');
				    copy('petition-files/share_for_starters.php', 'p/' . $path . '/share_for_starters.php');
				    copy('petition-files/download_signatures.php', 'p/' . $path . '/download_signatures.php');
				    copy('petition-files/submit_signature.php', 'p/' . $path . '/submit_signature.php');
				    copy('petition-files/submit_signature_mobile.php', 'p/' . $path . '/submit_signature_mobile.php');

				    $text = file_get_contents('p/' . $path . '/petitionId.php');
				    $text = str_replace('"Replace petition id here"', $petitionId, $text);
				    file_put_contents('p/' . $path . '/petitionId.php', $text);

			    	echo "p/" . $path ."/share_for_starters";
			    }
			    else{
			    	echo "Error";
			    }
			}
			else{
				echo "Error folder exists";
			}
		}
		else{
			header("Location: start.php");
			exit;
		}
?>
