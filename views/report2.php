<?php
include_once("../db.php");
include_once("../province.php");
include_once("../student.php");

$db = new Database();
$connection = $db->getConnection();

// Retrieve age distribution data from the database
$sqlAge = "SELECT FLOOR(DATEDIFF(CURDATE(), s.birthday) / 365) AS age, COUNT(*) as count FROM students s GROUP BY age";
$stmtAge = $connection->prepare($sqlAge);
$stmtAge->execute();
$ageData = $stmtAge->fetchAll(PDO::FETCH_ASSOC);

// Sort ageData array by age in ascending order
usort($ageData, function($a, $b) {
    return $a['age'] - $b['age'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report 2 - Age Distribution (Bar Chart)</title>
    <script src="/js/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="chart_div">
        <div class="content_report">
            <h2>Report 2 - Age Distribution (Bar Chart)</h2>
            <canvas id="age_chart"></canvas>
            <script defer>
                const ageData = <?php echo json_encode($ageData); ?>;
                const ageLabels = ageData.map(item => item.age);
                const ageCounts = ageData.map(item => item.count);

                const configAge = {
                    type: 'bar',
                    data: {
                        labels: ageLabels,
                        datasets: [{
                            label: 'Number of Students',
                            data: ageCounts,
                            backgroundColor: 'rgba(173, 216, 230, 0.2)', // Light Blue
                            borderColor: 'rgba(0, 0, 139, 1)',    
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Age'
                                },
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Students'
                                }
                            }
                        }
                    }
                };

                const ageChart = new Chart (
                    document.getElementById('age_chart'),
                    configAge
                );
            </script>
        </div>
    </div>
</body>
</html>
