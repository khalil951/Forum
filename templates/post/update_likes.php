<?php
// update_likes.php

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the JSON body sent by the client
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the increment property is set to true
    if (isset($data['increment']) && $data['increment'] === true) {
        // Increment the number of likes (You need to implement this logic)
        // For example, you might retrieve the current number of likes from a database and then increment it
        $currentLikes = 0; // Example current number of likes
        $newLikes = $currentLikes + 1;

        // Send the updated number of likes back to the client
        echo json_encode(['numLikes' => $newLikes]);
    } else {
        // If the increment property is not set or not true, return an error response
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
} else {
    // If the request method is not POST, return an error response
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
