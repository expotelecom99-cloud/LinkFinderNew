<?php
header('Content-Type: application/json');

$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Empty credentials"]);
    exit;
}

$targetUrl = "http://122.152.50.54:81/cnf_final/final/cms/admin/?app=admin&action=_default&msg=success&username=" . urlencode($username) . "&password=" . urlencode($password);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$error = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// যদি cURL এ কোনো এরর থাকে অথবা স্ট্যাটাস কোড ২০০ না হয়
if ($response === false) {
    echo json_encode(["status" => "error", "message" => "cURL Error: " . $error]);
} else {
    // সফল হলে সার্ভারের রেসপন্স দেখাবে
    echo json_encode(["status" => "success", "http_code" => $httpCode, "data" => $response]);
}
?>
