<?php
//  Include the database connection file
require_once '../db.php';


//  Set the header for JSON content type
header('Content-Type: application/json');


//  Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //  Retrieve data from the POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    //  Extract machine_id and encryption_key from the POST data
    $machine_id = $data['machine_id'] ?? '';
    $encryption_key = $data['encryption_key'] ?? '';


    //  Prepare the SQL statement to insert the data into the database
    $stmt = $pdo->prepare("INSERT INTO machine_keys (machine_id, encryption_key) VALUES (:machine_id, :encryption_key)");
    
    //  Bind the parameters
    $stmt->bindParam(':machine_id', $machine_id);
    $stmt->bindParam(':encryption_key', $encryption_key);


    //  Execute the statement and respond with the appropriate message
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data received successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'An error occurred']);
    }
} else {
    // Respond with an error message if the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

