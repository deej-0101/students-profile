<?php
include_once("../db.php");
include_once("../province.php");
include_once("../student.php");


$db = new Database();
$connection = $db->getConnection();

// Retrieve gender distribution data from the database
$sqlGender = "SELECT COUNT(*) as count, gender FROM students GROUP BY gender";
$stmtGender = $connection->prepare($sqlGender);
$stmtGender->execute();
$genderData = $stmtGender->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report 1 - Gender (Pie Chart)</title>
    <script src="/js/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="chart_div">
        <div class="content_report">
            <h2>Report 1 - Gender (Pie Chart)</h2>
            <canvas id="gender_chart"></canvas>
            <script defer>
                const genderData = <?php echo json_encode($genderData); ?>;
                const genderLabels = genderData.map(item => (item.gender === 1) ? 'Female' : 'Male');
                const genderCounts = genderData.map(item => item.count);

                const configGender = {
                    type: 'pie',
                    data: {
                        labels: genderLabels,
                        datasets: [{
                            data: genderCounts,
                            backgroundColor: [
                                'rgb(255, 192, 203)',
                                'rgb(0,255,255)',
                            ],
                            hoverOffset: 4
                        }]
                    }
                };

                const genderChart = new Chart (
                    document.getElementById('gender_chart'),
                    configGender
                );
            </script>
        </div>
    </div>
</body>
</html>
