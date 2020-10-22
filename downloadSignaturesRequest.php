<?php
	session_start();

    require_once("config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    $currDate = date("Y-m-d");

    if(isset($_POST)){
    	$petition_id = mysqli_real_escape_string($conn, $_POST['petition_id']);

        $isPetitionStarterSql = 'SELECT closed FROM petition WHERE id = ' . $petition_id . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: index.php");
        }
        else{
            $format = mysqli_real_escape_string($conn, $_POST['format']);
            $letter = mysqli_real_escape_string($conn, $_POST['letter']);
            $user_id = $_SESSION['userId'];

            $getUserEmail = "SELECT email FROM users WHERE id = " . $user_id;
            $getUserEmailQuery = mysqli_query($conn, $getUserEmail);
            if($row = mysqli_fetch_assoc($getUserEmailQuery)){
                $user_email = $row['email'];
            }
            else{
                echo "Error.";
                exit;
            }

            $getLastDownload = "SELECT date, format FROM download_signatures_requests WHERE petition_id = " . $petition_id . " ORDER BY id DESC LIMIT 1";
            $getLastDownloadQuery = mysqli_query($conn, $getLastDownload);
            if($row = mysqli_fetch_assoc($getLastDownloadQuery)){
                $year = substr($row['date'], 0, 4);
                $month = substr($row['date'], 5, 2);
                $day = substr($row['date'], 8, 2);
                $formatSelected = $row['format'];
            }
            else{
                $year = "0000";
                $month = "00";
                $day = "00";
								$formatSelected = "-";
            }

            $currYear = date("o");
            $currMonth = date("m");
            $currDay = date("d");

            if($format == $formatSelected){
                if($currDay <= $day){
                    if($currYear > $year || $currMonth > $month){
                        $downloadSignatures = 'INSERT INTO download_signatures_requests (petition_id, user_id, user_email, letter, format, date) VALUES (' . $petition_id . ', ' . $user_id . ', "' . $user_email . '", "' . $letter . '", "' . $format . '", "' . $currDate . '")';
                        $downloadSignaturesQuery = mysqli_query($conn, $downloadSignatures);

                        if(!$downloadSignaturesQuery){
                            echo "Error.1";
                            exit;
                        }
                        else{
                            echo "Success";
                            exit;
                        }
                    }
                    else{
                        echo "You can download one signature document per day.";
                        exit;
                    }
                }
                else{
                    $downloadSignatures = 'INSERT INTO download_signatures_requests (petition_id, user_id, user_email, letter, format, date) VALUES (' . $petition_id . ', ' . $user_id . ', "' . $user_email . '", "' . $letter . '", "' . $format . '", "' . $currDate . '")';
                    $downloadSignaturesQuery = mysqli_query($conn, $downloadSignatures);

                    if(!$downloadSignaturesQuery){
                        echo "Error.2";
                        exit;
                    }
                    else{
                        echo "Success";
                        exit;
                    }
                }
            }
            else{
                $downloadSignatures = 'INSERT INTO download_signatures_requests (petition_id, user_id, user_email, letter, format, date) VALUES (' . $petition_id . ', ' . $user_id . ', "' . $user_email . '", "' . $letter . '", "' . $format . '", "' . $currDate . '")';
                $downloadSignaturesQuery = mysqli_query($conn, $downloadSignatures);

                if(!$downloadSignaturesQuery){
									echo mysqli_error($conn);
                    echo "Error.3";
                    exit;
                }
                else{
                    echo "Success";
                    exit;
                }
            }
        }
    }
    else{
    	echo "Error.4";
    	exit;
    }
?>
