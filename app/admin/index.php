<?php
require '../../config/config.php';
require '../../config/functions.php';
requireRole('admin');

logActivity(
    $pdo,
    $_SESSION['user_id'],
    $_SESSION['user_email'],
    'view_activity_logs',
    'success'
);

//Activity Logs Query#3
$stmt = $pdo->query("
    SELECT *
    FROM activity_logs
    ORDER BY activity_log_create_at DESC
    ");
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.4/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Welcome Admin</h1>
            <a href="../../auth/signout.php" class="btn btn-outline-danger">Sign Out</a>
        </div>
        <table id="example" class="table table-bordered table-striped table-hover" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>Record ID</th>
                    <th>User ID</th>
                    <th>User Email</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($activities as $activity): ?>
                    <tr>
                        <td><?= htmlspecialchars($activity['activity_logs_id']) ?></td>
                        <td><?= htmlspecialchars($activity['user_id']) ?></td>
                        <td><?= htmlspecialchars($activity['user_email']) ?></td>
                        <td><?= htmlspecialchars($activity['activity_log_action']) ?></td>
                        <td><?= htmlspecialchars($activity['activity_log_status']) ?></td>
                        <td><?= htmlspecialchars($activity['activity_log_address']) ?></td>
                        <td><?= htmlspecialchars($activity['activity_log_user_agent']) ?></td>
                        <td><?= htmlspecialchars($activity['activity_log_create_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/3.0.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/3.0.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        new DataTable('#example', {
            scrollY: '400px',
            scrollCollapse: true,
            autoWidth: false,
            ordering: true,
            paging: true,
        });
    </script>

</body>
</html>