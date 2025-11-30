<?php
include 'config.php';
include 'nav-bar.php';

$pdo = new PDO($dsn, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* 1) PIE CHART: posts per module */
$sqlPie = "
    SELECT m.moduleName AS moduleName, COUNT(*) AS post_count
    FROM posts p
    JOIN modules m ON p.moduleID = m.moduleID
    GROUP BY p.moduleID
    ORDER BY moduleName ASC
";
$stmtPie = $pdo->query($sqlPie);

$moduleLabels = [];
$moduleCounts = [];

while ($row = $stmtPie->fetch(PDO::FETCH_ASSOC)) {
    $moduleLabels[] = $row['moduleName'];
    $moduleCounts[] = (int) $row['post_count'];
}

/* 2) LINE CHART: posts per day in the last 7 days (including today) */

// Build the last 7 dates in PHP so we can fill missing days with 0
$last7Dates = [];
for ($i = 6; $i >= 0; $i--) {
    $last7Dates[] = date('Y-m-d', strtotime("-$i day"));
}

// Query counts grouped by date
$sqlLine = "
    SELECT DATE(dateCreated) AS d, COUNT(*) AS c
    FROM posts
    WHERE dateCreated >= CURDATE() - INTERVAL 6 DAY
    GROUP BY DATE(dateCreated)
";
$stmtLine = $pdo->query($sqlLine);

$countsByDate = array_fill_keys($last7Dates, 0);

while ($row = $stmtLine->fetch(PDO::FETCH_ASSOC)) {
    $date = $row['d'];
    if (isset($countsByDate[$date])) {
        $countsByDate[$date] = (int) $row['c'];
    }
}

$lineLabels = $last7Dates;                 // x-axis labels
$lineCounts = array_values($countsByDate); // y-axis data

/* 3) LEADERBOARD: top users by post count */
$sqlBoard = "
    SELECT u.username, COUNT(*) AS post_count
    FROM posts p
    JOIN users u ON p.userID = u.userID
    GROUP BY p.userID
    ORDER BY post_count DESC
    LIMIT 10
";
$stmtBoard = $pdo->query($sqlBoard);

$leaderboardUsers  = [];
$leaderboardCounts = [];

while ($row = $stmtBoard->fetch(PDO::FETCH_ASSOC)) {
    $leaderboardUsers[]  = $row['username'];
    $leaderboardCounts[] = (int) $row['post_count'];
}
include 'templates/stats.html.php';
?>