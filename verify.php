<?php
header('Content-Type: application/json');

$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Empty credentials"]);
    exit;
}

// আপনার কাঙ্ক্ষিত সার্ভার লিংক যেখানে ইউজারনেম ও পাসওয়ার্ড চেক করা হবে
$targetUrl = "http://122.152.50.54:81/cnf_final/final/cms/admin/?app=admin&action=_default&msg=success&username=" . urlencode($username) . "&password=" . urlencode($password);

// cURL দিয়ে সার্ভারে রিকোয়েস্ট পাঠানো
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// যদি সার্ভার থেকে সফল রেসপন্স আসে (যেমন HTTP Status 200)
if ($response !== false && $httpCode >= 200 && $httpCode < 400) {
    echo json_encode(["status" => "success", "data" => $response]);
} else {
    echo json_encode(["status" => "error", "message" => "Server connection failed", "code" => $httpCode]);
}
?>
