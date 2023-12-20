<?php
include_once("../db.php");
include_once("../town_city.php");

$db = new Database();
$connection = $db->getConnection();
$town = new TownCity($db);

$query = "SELECT count(*) as 'total' FROM province"; # get total rows
$stmt = $db->getConnection()->prepare($query);
$stmt->execute();

$total_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rows_per_page = 30;
$number_of_pages = ceil($total_rows[0]['total'] / $rows_per_page);

if(!isset($_GET['page'])){
    $page = 1;
}else{
    $page = $_GET['page'];
}

$page_first_result = ($page - 1) * $rows_per_page;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Town City Records</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <?php include('../templates/header.html'); ?>
        <?php include('../includes/navbar.php'); ?>

        <div class="content">
            <h2>Town City Records</h2>
            <table class="orange-theme">
                <thead>
                    <tr>
                        <th>Name</th> <!-- will change -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr> -->
                    <?php
                    $results = $town->displayLimit($page_first_result,$rows_per_page);
                    foreach ($results as $x) {
                        echo '<tr>';
                        echo "<td>" . $x['name'] . "</td>";
                        echo "<td><a href=town_city_edit.php?id=". $x['id'].">Edit</a>|<a href=town_city_delete.php?id=". $x['id'].">Delete</a></td>";
                        echo '</tr>';
                    }
                    ?>
                    <!-- </tr> -->
                </tbody>
            </table>
            <a class="button-link" href="town_city_add.php">Add New Record</a>
            <div class="page_div">
                <?php
                for($page = 1; $page <= $number_of_pages; $page++){
                    echo '<a class=page_btn href="town_city.view.php?page='. $page . '">' . $page . '</a>';
                }?>
            </div>
        </div>
    </body>
</html>