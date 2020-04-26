<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
    <title>Admin Panel</title>
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION["message"])) { ?>
        <div class="header">
            <h1 class="admin_panel">Welcome to your Admin Panel!</h1>
            <button type="submit" class="btn btn-primary"><a href="logout.php" class="logout">Logout</a></button>
        </div>
        <h2 class="admin_users">Current users in database</h2>
        <table class="user_tab">
            <tbody>
                <tr>
                    <?php include_once("users.php"); ?>
                    <?php 
                        $order = "ASC";
                        if(isset($_GET["order"])) {
                            if($_GET["order"] === "ASC") {
                                $order = "DESC";
                            }
                            if($_GET["order"] === "DESC") {
                                $order = "ASC";
                            }
                        }
                    ?>
                    <td><a href="admin.php?parameter=id&order=<?php echo $order?>&page=<?php echo $currentPage?>">ID</a></td>
                    <td><a href="admin.php?parameter=email&order=<?php echo $order?>&page=<?php echo $currentPage?>">Email</a></td>
                    <td><a href="admin.php?parameter=name&order=<?php echo $order?>&page=<?php echo $currentPage?>">Lastname</a></td>
                    <td><a href="admin.php?parameter=firstname&order=<?php echo $order?>&page=<?php echo $currentPage?>">Firstname</a></td>
                    <td>Delete</td>
                </tr>
                <?php
                

                foreach ($users as $user) {
                ?>
                    <tr>
                        <td><a href="admin.php?displayuser=<?php echo $user["id"]?>">
                            <?php
                            echo $user["id"] . "\n";

                            ?>
                        </a></td>

                        <td>
                            <?php
                            echo $user["email"] . "\n";
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $user["name"] . "\n";
                            ?>
                        </td>
                        <td>
                        <?php
                        echo substr($user["firstname"], 0, 1) . "\n";
                    
                        ?>
                        <td>
                        <?php
                        ?>
                            <button type="submit" class="btn btn-primary"><a href="admin.php?delete=<?php echo $user['id']?>" class="delete">Delete</a></button>
                        <?php
                    }
                        ?>
                        </td>
                    </tr>
            </tbody>
        </table>
        <?php
            if($currentPage > 1) {
                  
        ?>
        <button type="submit" class="btn btn-primary"><a href="admin.php?page=<?php echo $currentPage-1 ?>" class="logout">Previous</a></button>
        <?php
            }
            if($currentPage < $pages) {
        ?>
        <button type="submit" class="btn btn-primary"><a href="admin.php?page=<?php echo $currentPage+1 ?>" class="logout">Next</a></button>
        <?php
            }
        ?>
    <?php } 
    else { 
    ?>
        <h1 class="admin_panel">You're not authorized to see this page!</h1>
    <?php
    }
    ?>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>