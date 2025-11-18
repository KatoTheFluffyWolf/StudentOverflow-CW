<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudentOverflow – Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container py-4">
    <h1 class="h3 mb-4">Site Statistics</h1>

    <div class="row g-4">
        <!-- Pie chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Posts by Module</div>
                <div class="card-body">
                    <canvas id="postsByModule"></canvas>
                </div>
            </div>
        </div>

        <!-- Line chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Posts in the Last 7 Days</div>
                <div class="card-body">
                    <canvas id="postsLastWeek"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <!-- Leaderboard -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">Top Contributors</div>
                <div class="card-body">
                    <canvas id="leaderboardChart" height="100"></canvas>

                    <!-- Optional: also show as a table -->
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Posts</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($leaderboardUsers as $i => $username): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($username) ?></td>
                                    <td><?= (int) $leaderboardCounts[$i] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Pass PHP data into JS
const pieLabels       = <?= json_encode($moduleLabels) ?>;
const pieData         = <?= json_encode($moduleCounts) ?>;

const lineLabels      = <?= json_encode($lineLabels) ?>;
const lineData        = <?= json_encode($lineCounts) ?>;

const leaderboardUsers  = <?= json_encode($leaderboardUsers) ?>;
const leaderboardCounts = <?= json_encode($leaderboardCounts) ?>;

// 1) Pie chart: posts per module
new Chart(
    document.getElementById('postsByModule'),
    {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Total Posts by Module'
                }
            }
        }
    }
);

// 2) Line chart: posts per day (last 7 days)
new Chart(
    document.getElementById('postsLastWeek'),
    {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: [{
                label: 'Posts per day',
                data: lineData,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    }
);

// 3) Leaderboard: top users by posts (bar chart)
new Chart(
    document.getElementById('leaderboardChart'),
    {
        type: 'bar',
        data: {
            labels: leaderboardUsers,
            datasets: [{
                label: 'Number of posts',
                data: leaderboardCounts
            }]
        },
        options: {
            indexAxis: 'y', // horizontal bars (nice for leaderboard)
            scales: {
                x: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    }
);
</script>
</body>
</html>
