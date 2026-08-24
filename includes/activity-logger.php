<?php
function logActivity($pdo,$user_id,$email,$action,$status='success'){
try{

    //get client id address
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    //String to array
    if(strpos($ip, ',') !==false){
        $ip = trim(explode(',',$ip)[0]);

    }

    // Get user agent (browser)
    $user_Agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN', 0, 255);

    //APPLICATION qUERY #1
  $stmt = $pdo->prepare("
    INSERT INTO activity_logs (
        user_id,
        user_email,
        activity_log_action,
        activity_log_status,
        activity_log_address,
        activity_log_user_agent
    ) VALUES (?, ?, ?, ?, ?, ?)
");

$success = $stmt->execute([
    $user_id,
    $email,
    $action,
    $status,
    $ip,
    $user_Agent
]);


            return $success;


}catch(PDOException $e){
    error_log("Activity log Error:" .$e->getMessage());
    return false;

}
}

?>