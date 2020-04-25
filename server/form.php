<?php

header('Access-Control-Allow-Origin: *');
setlocale(LC_TIME, "fr_FR");

// header('Access-Control-Allow-Headers: *');
// header('Content-Type: application/x-www-form-urlencoded');
// header('Content-Type: application/json');

//var_dump($_POST);
$server = "localhost";
$username = "root";
$password = "root";
$mailRegex = "/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
$phoneRegex = "/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/";

/**
 * Form data
 */
$date = date('d-m-Y', strtotime(str_replace('/', '-', $_POST["birthdate"])));

//var_dump($date);

/**
 * Checks if the form has been submitted and establish a connection to the database if that's the case
 * 
 * If the connection works, sent data are added to the database. Provide an error message otherwise.
 */
if (isset($_POST)) {
    if ($_POST['email'] !== "" && preg_match($mailRegex, $_POST["email"]) && preg_match($phoneRegex, $_POST["phone"])) {
        try {
            $connection = new PDO("mysql:host=" . $server . ";dbname=rattrapage_01", $username, $password);
            // set error mode
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $request = "INSERT INTO internautes (name, firstname, birthdate, picture, phone, address, email) 
            VALUES (:lastname, :firstname, :birthdate, :picture, :phone, :address, :email)";

            $stmt = $connection->prepare($request);

            $stmt->bindParam(':lastname', $_POST["lastname"]);
            $stmt->bindParam(':firstname', $_POST["firstname"]);
            $stmt->bindParam(':birthdate', $_POST["birthdate"]);
            $stmt->bindParam(':picture', $_POST["picture"]);
            $stmt->bindParam(':phone', $_POST["phone"]);
            $stmt->bindParam(':address', $_POST["address"]);
            $stmt->bindParam(':email', $_POST["email"]);
            $stmt->execute();

            echo "success";
        } catch (PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
    }
    else {
        echo "mail or phone field error detected";
    }
}
