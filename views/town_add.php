<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php"); // Include the Student class file
include_once("../student_details.php"); // Include the Student class file
include_once("../town_city.php");
include_once("../province.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'name' => $_POST['name']
    ];

    // Instantiate the Database and Student classes
    $database = new Database();
    $town_city = new TownCity($database);
    $id = $town_city->create($data);
    
    if ($id) {
        // Student record successfully created
        
        // Retrieve student details from the form
        $town_city_data = [
            'name' => $_POST['name'],
        ];

    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Town Ctiy</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1>Add Town / Data</h1>
    <form action="" method="post" class="centered-form">

        <label for="name">Town / City:</label>
        <input type="text" name="name" id="name" required>

        <input type="submit" value="Add Town/City">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>
