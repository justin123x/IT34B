<?php
require_once('config/config.php');

$user_id = "root" ?? null;
$user_email = "root" ?? null;

$success = logActivity($pdo, $user_id, $user_email, 'test_activity_', 'success');


if($success){
    echo "Activity log inseredsuvvessfully.";

}else{
        echo "Failed to insert activityt log";

}

?>