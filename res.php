<?php
// res.php

include 'config.php'; // DB connection

$servername = "localhost";
$username = "root";
$password = "";
$database = "quiz_game";

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Quiz Results</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-green-600 text-white text-sm uppercase">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Mobile</th>
                        <th class="py-3 px-4">Score</th>
                        <th class="py-3 px-4">Total Questions</th>
                        <th class="py-3 px-4">Percentage</th>
                        <th class="py-3 px-4">Time Taken (s)</th>
                        <th class="py-3 px-4">Completed At</th>
                    </tr>
                </thead>
                <tbody class="text-center text-gray-700">
                    <?php
                    $rank = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class='border-t hover:bg-gray-100 transition'>
                                <td class='py-3 px-4 font-semibold'>{$rank}</td>
                                <td class='py-3 px-4'>{$row['name']}</td>
                                <td class='py-3 px-4'>{$row['mobile']}</td>
                                <td class='py-3 px-4'>{$row['score']}</td>
                                <td class='py-3 px-4'>{$row['total_questions']}</td>
                                <td class='py-3 px-4'>{$row['percentage']}%</td>
                                <td class='py-3 px-4'>{$row['time_taken']}</td>
                                <td class='py-3 px-4 text-sm text-gray-600'>{$row['completed_at']}</td>
                              </tr>";
                        $rank++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
