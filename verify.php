<?php
header('Content-Type: application/json');

$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Empty credentials"]);
    exit;
}

// আপনার টার্গেট সার্ভার লিংক
$targetUrl = "http://122.152.50.54:81/cnf_final/final/cms/admin/?app=admin&action=_default&msg=success&username=" . urlencode($username) . "&password=" . urlencode($password);

// cURL ব্যবহার করে সার্ভার সংযোগ করা (যা ব্রাউজার বা হোস্টিংয়ের ফাইল ওপেন রেস্ট্রিকশন এড়াতে সাহায্য করে)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15); // ১৫ সেকেন্ড টাইমআউট
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// যদি সার্ভার থেকে সফল রেসপন্স আসে
if ($response !== false && $httpCode >= 200 && $httpCode < 400) {
    echo json_encode(["status" => "success", "data" => $response]);
} else {
    echo json_encode(["status" => "error", "message" => "Server connection failed", "code" => $httpCode]);
}
?>
