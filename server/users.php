<?php

/**
 * DB Infos
 */
$server = "localhost";
$username = "root";
$password = "root";

try {
    $connection = new PDO("mysql:host=" . $server . ";dbname=rattrapage_01", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_GET['limit'])) {
        $limit = $_GET['limit'];
    }
    else {
        $limit = 5;
    }

    /**
     * First, we get the number of users in database
     */
    $usersCountQuery = "SELECT * FROM internautes";
    $query = $connection->prepare($usersCountQuery);
    $query->execute();
    $numberOfUsers = $query->fetchAll();
    $numberOfUsers = count($numberOfUsers);
    $order = "ASC";

    /**
     * Then we do all the pagination logic with the number of pages
     * and number of element we want to display
     */
    
    if(isset($_GET['page'])) {
        $currentPage = (int)$_GET["page"];
    }
    else {
        $currentPage = 1;
    }

    if(isset($_GET["parameter"])) {
        $parameter = $_GET["parameter"];
    }
    else {
        $parameter = "id";
    }

    if(isset($_GET['order'])) {
        $order = $_GET["order"];
    }

    $perPage = 5;
    $pages = ceil($numberOfUsers / $perPage);
    $offset = $perPage * ($currentPage -1);
    
    
    $request = "SELECT * FROM internautes ORDER BY $parameter $order LIMIT $perPage OFFSET $offset";
    //var_dump($request);
    $stmt = $connection->prepare($request);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} 
catch (PDOException $e) {
    echo "Connection failed : " . $e->getMessage();
}

if(isset($_GET['displayuser'])) {
    $id = $_GET['displayuser'];

    /**
     * Query to get user info from database
     */
    $userToQuery = "SELECT * FROM internautes WHERE id = :id";
    $userQuery = $connection->prepare($userToQuery);
    $userQuery->execute(['id' => $id]);

    $currentUser = $userQuery->fetchAll(PDO::FETCH_ASSOC);

    $user_file_extension = pathinfo($currentUser[0]['picture']);
    $user_file_extension = $user_file_extension['extension'];
    $user_file_name = strtolower(str_replace(" ", "_", $currentUser[0]['lastname'])) . "." . strtolower(str_replace(" ", "_", $currentUser[0]['firstname'])) . "." . $file_extension;

    var_dump($currentUser);
}

if(isset($_GET['delete'])) {
    $id = $_GET["delete"];

    /**
     * Query to delete user from database
     */
    $userToDelete = "DELETE FROM internautes WHERE id = :id";
    $deleteQuery = $connection->prepare($userToDelete);
    $deleteQuery->execute(['id' => $id]);

    header('Location: http://localhost:8000/admin.php');
}
