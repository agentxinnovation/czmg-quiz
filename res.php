<?php
// res.php

include 'config.php'; // DB connection

// Fetch results joined with user info, sorted by score DESC and time_taken ASC

$servername = "localhost";
$username = "root";       // change if not root
$password = "";           // add your DB password
$database = "quiz_game"; // change to your actual DB name

$conn = mysqli_connect($servername, $username, $password, $database);
$query = "
    SELECT 
        u.name,
        u.mobile,
        qr.score,
        qr.total_questions,
        qr.percentage,
        qr.time_taken,
        qr.completed_at
    FROM quiz_results qr
    INNER JOIN users u ON qr.user_id = u.id
    ORDER BY qr.score DESC, qr.time_taken ASC
";


$result = mysqli_query($conn, $query);
// echo "<pre>";
// print_r($result);
// echo "</pre>";
// if (!$result) {
//     die("Query Failed: " . mysqli_error($conn));
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Results</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px; }
        table { border-collapse: collapse; width: 100%; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        h2 { color: #333; }
    </style>
</head>
<body>

<h2>Quiz Results</h2>
<table>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Score</th>
        <th>Total Questions</th>
        <th>Percentage</th>
        <th>Time Taken (seconds)</th>
        <th>Completed At</th>
    </tr>

    <?php
    $rank = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$rank}</td>
                <td>{$row['name']}</td>
                <td>{$row['mobile']}</td>
                <td>{$row['score']}</td>
                <td>{$row['total_questions']}</td>
                <td>{$row['percentage']}%</td>
                <td>{$row['time_taken']}</td>
                <td>{$row['completed_at']}</td>
              </tr>";
        $rank++;
    }
    ?>

</table>

</body>
</html>
