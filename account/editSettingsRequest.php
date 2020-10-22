<?php
    session_start();
    if(!isset($_SESSION['isLogged'])){
        header("Location: ../index.php");
    }
    require_once("../config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    if(isset($_POST)){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $zip = $_POST['zip'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $phoneNumber = $_POST['phoneNumber'];
        $website = $_POST['website'];
        $aboutMe = $_POST['aboutMe'];
        if($city == "") $city = "default";
        if($country == "") $country = "default";

        $mysqlUpdate = 'UPDATE users SET firstName="' . $firstName . '",lastName="' . $lastName . '", address="' . $address . '",zip="' . $zip . '",city="' . $city . '",country="' . $country . '",state="' . $state . '",phoneNumber="' . $phoneNumber . '",website="' . $website . '",aboutMe="' . $aboutMe . '"  WHERE id = ' . $_SESSION['userId'];
        $query = mysqli_query($conn,$mysqlUpdate);

        if($query){
            $_SESSION['name'] = $firstName;
            echo "Success";
        }
        else{
            echo "Error";
        }
    }

    $mysql = 'SELECT * FROM users WHERE id = ' . $_SESSION['userId'];
    $query = mysqli_query($conn,$mysql);
    if($row = mysqli_fetch_assoc($query)){
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $address = $row['address'];
        $zip = $row['zip'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        $phoneNumber = $row['phoneNumber'];
        $website = $row['website'];
        $aboutMe = $row['aboutMe'];
    }
?>