<?php
require_once '../../config/config.php';


requireRole('admin');

logActivity($pdo,$_SESSION['user_id'],
        $_SESSION['user_email'],
        'view_activity_logs',
        'success'
);

// Determine current section
$section = $_GET['section'] ?? 'activity-logs';

// Determine CRUD Operation
$action = $_GET['action'] ?? '';

// Fetch data based on current section
if ($section === 'activity-logs') {

    // Activity Logs Query
    $stmt = $pdo->query("
        SELECT *
        FROM activity_logs
        ORDER BY activity_log_create_at DESC
    ");

    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif ($section === 'user-sessions') {

    // User Sessions Query
    $stmt = $pdo->query("
        SELECT
            us.session_id,
            us.user_id,
            u.user_username,
            u.user_email,
            u.user_role,
            us.session_start,
            us.session_end,
            us.session_duration
        FROM user_sessions us
        INNER JOIN users u
            ON us.user_id = u.user_id
        ORDER BY us.session_start DESC
    ");

    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />
</head>

<body>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Admin Dashboard</h1>
            <a href="../../auth/signout.php" class="btn btn-light btn-sm border">Sign Out</a>
        </div>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link <?= $section === 'activity-logs' ? 'active fw-bold' : '' ?>"
                   href="index.php?section=activity-logs">Activity Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link <?= $section === 'user-sessions' ? 'active fw-bold' : '' ?>"
                   href="index.php?section=user-sessions">User Sessions</a>
            </li>
        </ul>

        <?php if ($section === 'activity-logs'): ?>

            <h4>Activity Logs</h4>

            <table id="activityTable" class="table table-bordered table-sm mb-0">

                <thead class="table-light">
                    <tr>
                        <th>Record ID</th>
                        <th>User ID</th>
                        <th>User Email</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($activities as $activity): ?>

                    <tr>
                        <td>
                            <?= htmlspecialchars($activity['activity_logs_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['user_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['user_email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_action']) ?>
                        </td>

                        <td>
                            <?php if ($activity['activity_log_status'] === 'success'): ?>
                                <span class="badge badge-success"><?= htmlspecialchars($activity['activity_log_status']) ?></span>
                            <?php else: ?>
                                <span class="badge badge-danger"><?= htmlspecialchars($activity['activity_log_status']) ?></span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_address']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_user_agent']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($activity['activity_log_create_at']) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>


    <?php if ($section === 'user-sessions'): ?>

        <h4>User Sessions</h4>

        <table id="sessionTable" class="table table-bordered table-sm mb-0">

            <thead class="table-light">
                <tr>
                    <th>Session ID</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Session Start</th>
                    <th>Session End</th>
                    <th>Duration</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($sessions as $session): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($session['session_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_username']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['user_role']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($session['session_start']) ?>
                        </td>

                        <td>
                            <?= $session['session_end']
                                ? htmlspecialchars($session['session_end'])
                                : 'Active'
                            ?>
                        </td>

                        <td>

                            <?php

                                if ($session['session_duration'] !== null) {

                                    $seconds = (int) $session['session_duration'];

                                    $hours = floor($seconds / 3600);
                                    $minutes = floor(($seconds % 3600) / 60);
                                    $seconds = $seconds % 60;

                                    echo sprintf(
                                        '%02d hr %02d min %02d sec',
                                        $hours,
                                        $minutes,
                                        $seconds
                                    );

                                } else {

                                    echo 'Ongoing';

                                }

                            ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

     <script>
         $('#activityTable, #sessionTable').DataTable({
             paging: false,
             info: false,
             searching: false,
             ordering: false
         });
     </script>
</body>
</html>