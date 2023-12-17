<?php
include_once("../db.php");
include_once("../province.php");
include_once("../student.php");

$db = new Database();
$connection = $db->getConnection();

// Retrieve birth month distribution data from the database
$sqlBirthMonth = "SELECT MONTH(birthday) AS month, COUNT(*) as count FROM students GROUP BY month ORDER BY month";
$stmtBirthMonth = $connection->prepare($sqlBirthMonth);
$stmtBirthMonth->execute();
$birthMonthData = $stmtBirthMonth->fetchAll(PDO::FETCH_ASSOC);

// Define the order of months
$orderedMonths = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report 5 - Students Distribution by Birth Month Line Chart</title>
    <script src="/js/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="chart_div">
        <div class="content_report">
            <h2>Students Distribution by Birth Month Line Chart</h2>
            <canvas id="birth_month_chart"></canvas>
            <script defer>
                const birthMonthData = <?php echo json_encode($birthMonthData); ?>;
                const orderedMonths = <?php echo json_encode($orderedMonths); ?>;
                const birthMonthCounts = Array.from({ length: 12 }, (_, index) => {
                    const monthData = birthMonthData.find(item => parseInt(item.month) === index + 1);
                    return monthData ? monthData.count : 0;
                });

                const configBirthMonth = {
                    type: 'line',
                    data: {
                        labels: orderedMonths,
                        datasets: [{
                            label: 'Number of Students',
                            data: birthMonthCounts,
                            fill: false,
                            borderColor: 'rgba(75, 192, 192, 1)', // Aqua color
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
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

                const birthMonthChart = new Chart (
                    document.getElementById('birth_month_chart'),
                    configBirthMonth
                );
            </script>
        </div>
    </div>
</body>
</html>
