<?php
include_once("../db.php");
include_once("../student.php");
include_once("../student_details.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);
$student_details = new StudentDetails($db);

$query = "SELECT count(*) as 'total' FROM province"; 
$stmt = $db->getConnection()->prepare($query);
$stmt->execute();
$total_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rows_per_page = 50;
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
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Student Records</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>Student Number</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Action</th>
                <th>Contact Number</th>
                <th>Street</th>
                <th>Town City</th>
                <th>Province</th>
                <th>Zip Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
       
            
            
            <?php
            $results = $student->displayAll(); 
            foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result['student_number']; ?></td>
                <td><?php echo $result['first_name']; ?></td>
                <td><?php echo $result['middle_name']; ?></td>
                <td><?php echo $result['last_name']; ?></td>
                <td><?php echo $result['gender']; ?></td>
                <td><?php echo $result['birthday']; ?></td>
                <?php
                    $y = $student_details->searchStudent($x['id']);
                    echo "<td>". $y['contact_number'] ."</td>";
                    echo "<td>". $y['street'] ."</td>";
                    echo "<td>". $y['town_city'] ."</td>";
                    echo "<td>". $y['province'] ."</td>";
                    echo "<td>". $y['zip_code'] ."</td>";
                ?>
                <td>
                    <a href="student_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    |
                    <a href="student_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

           
        </tbody>
    </table>
        
    <a class="button-link" href="student_add.php">Add New Record</a>
    <div class="pages">
        <?= implode('', array_map(fn($page) => "<a class='pagebutton' href='students.view.php?page=$page'>$page</a>", range(1, $number_of_pages))) ?>
    </div>



        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>
