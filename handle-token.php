<?php
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$accessToken = $data['accessToken'];

if (!$accessToken) {
    echo json_encode(['success' => false, 'message' => 'No access token provided']);
    exit;
}

// Verify the access token and get user information
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=$accessToken");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$userData = json_decode($response, true);

if (isset($userData['error'])) {
    echo json_encode(['success' => false, 'message' => $userData['error']['message']]);
} else {
    // User data is available, handle user login or registration
    echo json_encode(['success' => true, 'userData' => $userData]);
}
?>
