<?php
	session_start();

    require_once("config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    if(isset($_POST)){
        $petition_id = mysqli_real_escape_string($conn, $_POST['petition_id']);
        $start_from = mysqli_real_escape_string($conn, $_POST['start_from']);

		$getSupporters = 'SELECT firstName, lastName, public, date, reason, country FROM user_petitions WHERE petition_id = ' . $petition_id . ' ORDER BY id DESC LIMIT ' . $start_from . ', 15';
        $getSupportersQuery = mysqli_query($conn, $getSupporters);

        if(!$getSupportersQuery){
            echo "Error";
            exit;
        }
        else{
            while($row = mysqli_fetch_assoc($getSupportersQuery)){
                $date = strtotime($row['date']);
                if($row['public'] == 0){
                    $names = "Name not displayed";
                }
                else{
                    $names = $row['firstName'] . ' ' . $row['lastName'];
                }
                echo '<div class="supporters-item">
                        <div class="supporter-img"><img alt src="/images/supporter.png" style="width: 100%"></div>
                        <div class="supporter-name">' . $names . ' <span class="supporter-date">signed ' . time_elapsed_string(date("Y-m-d G:H:s", $date)) . '</span> <br> <div class="supporter-country">' . $row['country'] . '</div></div>
                        <div class="supporter-reason-for-signing">' . $row['reason'] . '</div>
                    </div>';
            }
        }    	
    }
    else{
    	echo "Error";
    	exit;
    }
?>