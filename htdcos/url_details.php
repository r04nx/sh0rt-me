<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit();
}

$url_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$url_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM urls WHERE id = $url_id"));

if (!$url_data) {
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>URL Details - <?php echo $url_data['shorturl']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<nav class="blue darken-1">
    <div class="nav-wrapper container">
        <a href="admin.php" class="breadcrumb">Admin</a>
        <a href="#!" class="breadcrumb">URL Details</a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">URL Information</span>
                    <p><strong>Short URL:</strong> <?php echo $url_data['shorturl']; ?></p>
                    <p><strong>Original URL:</strong> <?php echo $url_data['longurl']; ?></p>
                    <p><strong>Created:</strong> <?php echo $url_data['time']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Analytics -->
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Recent Visitors</span>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $visitors_query = "SELECT * FROM url_analytics WHERE url_id = $url_id ORDER BY visited_at DESC LIMIT 100";
                            $visitors_result = mysqli_query($conn, $visitors_query);
                            while ($visitor = mysqli_fetch_assoc($visitors_result)):
                            ?>
                            <tr>
                                <td><?php echo $visitor['visited_at']; ?></td>
                                <td><?php echo $visitor['visitor_ip']; ?></td>
                                <td><?php echo $visitor['user_agent']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- File Manager Section -->
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left">folder</i>
                        File Manager
                    </span>
                    
                    <!-- Upload Form -->
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-4">
                        <div class="file-field input-field">
                            <div class="btn blue">
                                <span><i class="material-icons left">cloud_upload</i>Upload</span>
                                <input type="file" name="files[]" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload one or more files">
                            </div>
                        </div>
                        <div class="switch">
                            <label>
                                Private
                                <input type="checkbox" name="is_public">
                                <span class="lever"></span>
                                Public
                            </label>
                        </div>
                        <button class="btn waves-effect waves-light blue right" type="submit">
                            <i class="material-icons left">send</i>Upload Files
                        </button>
                    </form>

                    <!-- File Browser -->
                    <div class="file-browser">
                        <?php
                        $files_query = "SELECT * FROM files ORDER BY upload_date DESC";
                        $files_result = mysqli_query($conn, $files_query);
                        ?>
                        <table class="striped highlight">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Uploaded</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($file = mysqli_fetch_assoc($files_result)): ?>
                                <tr>
                                    <td>
                                        <i class="material-icons">
                                            <?php echo getFileIcon($file['mime_type']); ?>
                                        </i>
                                    </td>
                                    <td><?php echo htmlspecialchars($file['original_name']); ?></td>
                                    <td><?php echo formatFileSize($file['file_size']); ?></td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($file['upload_date'])); ?></td>
                                    <td>
                                        <a href="download.php?id=<?php echo $file['id']; ?>" class="btn-floating btn-small blue">
                                            <i class="material-icons">download</i>
                                        </a>
                                        <a href="delete_file.php?id=<?php echo $file['id']; ?>" class="btn-floating btn-small red" onclick="return confirm('Are you sure?')">
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
</div>

</body>
</html> 