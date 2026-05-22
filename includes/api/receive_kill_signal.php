<?php
// Include the database connection file
require_once '../db.php';


// Initialize response array
$response = ['success' => false];


//  Check if machine_id is set in the POST request
if (isset($_POST['machine_id'])) {
    $machine_id = $_POST['machine_id'];


    //  Try to execute the SQL update statement
    try {
        //  Prepare the SQL statement to update stop_signal
        $stmt = $pdo->prepare("UPDATE machine_keys SET stop_signal = 1 WHERE machine_id = :machine_id");


        //  Bind the machine_id parameter
        $stmt->bindParam(':machine_id', $machine_id);


        // Execute the statement
        if ($stmt->execute()) {
            // Check if any rows were updated
            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
            } else {
                $response['error'] = 'No rows updated. Check if machine_id exists.';
            }
        } else {
            $response['error'] = 'Database update failed.';
        }
    } catch (PDOException $e) {
        // Handle any PDO exceptions
        $response['error'] = 'PDOException: ' . $e->getMessage();
    }
} else {
    //Handle missing machine_id in the POST request
    $response['error'] = 'Machine ID not provided.';
}


// Return the response as JSON
echo json_encode($response);
?>

