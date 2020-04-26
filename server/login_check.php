<?php

header('Access-Control-Allow-Origin: *');

/**
 * DB Infos
 */
$server = "localhost";
$username = "root";
$password = "root";

/**
 * Connection to DB if a request is sent
 */
if(isset($_POST)) {
    try {
        $connection = new PDO("mysql:host=" . $server . ";dbname=rattrapage_01", $username, $password);
        // set error mode
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $request = "SELECT id FROM admin WHERE user=:username AND password=:password";

        $stmt = $connection->prepare($request);
        $stmt->execute([
            'username' => $_POST["username"],
            'password' => $_POST['password']
        ]);

        $user = $stmt->fetch();

        if($user != false) {
            echo "success";
            session_start();
            $_SESSION["message"] = "success";
            header('Location: http://localhost:8000/admin.php');
            
        } else {
            echo "Invalid email, password or no user found";
        }
    } catch (PDOException $e) {
        echo "Connection failed : " . $e->getMessage();
    }
}
