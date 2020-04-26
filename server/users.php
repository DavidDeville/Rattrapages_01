<?php

/**
 * DB Infos
 */
$server = "localhost";
$username = "root";
$password = "root";

try {
    $connection = new PDO("mysql:host=" . $server . ";dbname=rattrapage_01", $username, $password);
    // set error mode
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
    var_dump($numberOfUsers);

    // var_dump(count($count)); 7 USERS

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

    $order = "ASC";
    
    if(isset($_GET['order'])) {
        $order = $_GET["order"];
    }

    $perPage = 5;
    $pages = ceil($numberOfUsers / $perPage);
    $offset = $perPage * ($currentPage -1);
    
    
    $request = "SELECT * FROM internautes ORDER BY $parameter $order LIMIT $perPage OFFSET $offset";
    var_dump($request);
    $stmt = $connection->prepare($request);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    //var_dump($pages);


} catch (PDOException $e) {
    echo "Connection failed : " . $e->getMessage();
}

?>