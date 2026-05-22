<?php
//  Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


//  Set the header for JSON content type
header('Content-Type: application/json'); 


//  Include database connection
require_once '../db.php'; 


//  Check if machine_id is provided and fetch stop_signal from database
if (isset($_GET['machine_id'])) {
    $machine_id = $_GET['machine_id'];
    $stmt = $pdo->prepare("SELECT stop_signal FROM machine_keys WHERE machine_id = :machine_id");
    $stmt->bindParam(':machine_id', $machine_id);
    
    //  Execute the prepared statement and fetch result
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['stop_signal' => $result['stop_signal'] ?? 0]);
    } else {
        //  Include error information if execute fails
        echo json_encode(['error' => $stmt->errorInfo()]);
    }
} else {
    //  Handle case where machine_id is not provided
    echo json_encode(['error' => 'Machine ID not provided.']);
}
?>

