<?php
session_start();
require_once('db.php');

// Basic authentication (enhance this in production)
if (!isset($_SESSION['admin']) && isset($_POST['password']) && $_POST['password'] === 'admin123') {
    $_SESSION['admin'] = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sh0rt me - Admin Panel</title>
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php if (!isset($_SESSION['admin'])): ?>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card-panel">
                    <h4 class="center-align">Admin Login</h4>
                    <form method="post">
                        <div class="input-field">
                            <input type="password" name="password" id="password" required>
                            <label for="password">Password</label>
                        </div>
                        <button class="btn waves-effect waves-light blue full-width" type="submit">
                            Login <i class="material-icons right">send</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>

<nav class="blue darken-1">
    <div class="nav-wrapper container">
        <a href="#" class="brand-logo">Sh0rt me Admin</a>
        <ul id="nav-mobile" class="right">
            <li><a href="?logout=true"><i class="material-icons left">exit_to_app</i>Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <!-- Dashboard Stats -->
    <div class="row">
        <div class="col s12 m3">
            <div class="card-panel blue white-text">
                <i class="material-icons medium">link</i>
                <h5>Total URLs</h5>
                <h3><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM urls")); ?></h3>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card-panel green white-text">
                <i class="material-icons medium">trending_up</i>
                <h5>Total Clicks</h5>
                <h3><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM url_analytics")); ?></h3>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card-panel orange white-text">
                <i class="material-icons medium">today</i>
                <h5>Today's Clicks</h5>
                <h3><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM url_analytics WHERE DATE(visited_at) = CURDATE()")); ?></h3>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card-panel red white-text">
                <i class="material-icons medium">device_hub</i>
                <h5>Active URLs</h5>
                <h3><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT url_id FROM url_analytics WHERE visited_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)")); ?></h3>
            </div>
        </div>
    </div>

    <!-- Analytics Chart -->
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Click Analytics (Last 7 Days)</span>
                    <canvas id="clicksChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- URL List with Analytics -->
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">URL Analytics</span>
                    <table class="striped responsive-table">
                        <thead>
                            <tr>
                                <th>Short URL</th>
                                <th>Original URL</th>
                                <th>Created</th>
                                <th>Total Visits</th>
                                <th>Last Visit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT u.*, COUNT(a.id) as visits, MAX(a.visited_at) as last_visit 
                                 FROM urls u 
                                 LEFT JOIN url_analytics a ON u.id = a.url_id 
                                 GROUP BY u.id 
                                 ORDER BY visits DESC";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)): 
                        ?>
                            <tr>
                                <td><a href="/<?php echo $row['shorturl']; ?>" target="_blank"><?php echo $row['shorturl']; ?></a></td>
                                <td><?php echo substr($row['longurl'], 0, 50) . '...'; ?></td>
                                <td><?php echo $row['time']; ?></td>
                                <td><?php echo $row['visits']; ?></td>
                                <td><?php echo $row['last_visit'] ?? 'Never'; ?></td>
                                <td>
                                    <a href="?action=details&id=<?php echo $row['id']; ?>" class="btn-small blue">
                                        <i class="material-icons">analytics</i>
                                    </a>
                                    <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn-small red" onclick="return confirm('Are you sure?')">
                                        <i class="material-icons">delete</i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize chart data
const ctx = document.getElementById('clicksChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php 
            $dates = [];
            $clicks = [];
            $query = "SELECT DATE(visited_at) as date, COUNT(*) as clicks 
                     FROM url_analytics 
                     WHERE visited_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                     GROUP BY DATE(visited_at)
                     ORDER BY date";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $dates[] = $row['date'];
                $clicks[] = $row['clicks'];
            }
            echo json_encode($dates);
        ?>,
        datasets: [{
            label: 'Clicks',
            data: <?php echo json_encode($clicks); ?>,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Initialize Materialize components
document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
});
</script>

<?php endif; ?>

</body>
</html>
?>
