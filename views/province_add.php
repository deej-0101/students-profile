<?php
include_once("../db.php");
include_once("../province.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'name' => $_POST['province_name']
    ];

    $db = new Database();
    $prov = new Province($db);
    $provData = $prov->create($data);
    if($provData){
        echo "add successful.";
    } else {
        echo "add unsuccessful.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Province Data</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1>Add Province Data</h1>
    <form action="" method="post" class="centered-form">

        <label for="province_name">Name:</label>
        <input type="text" name="province_name" id="province_name" required>

        <input type="submit" value="Add Province">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>