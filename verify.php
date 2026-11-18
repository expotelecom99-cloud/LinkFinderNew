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
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// এখানে চেক করা হচ্ছে রিমোট সার্ভার থেকে কোনো রেসপন্স এসেছে কি না 
// (যদি আপনার রিমোট সার্ভার সফল লগইনে নির্দিষ্ট কোনো লেখা বা পেজ দেয়, সেটি এখানে কন্ডিশন হিসেবে দেওয়া যাবে)
if ($response !== false && $httpCode >= 200 && $httpCode < 400) {
    // উদাহরণস্বরূপ: সার্ভার যদি ভুল পাসওয়ার্ড দিলে কোনো বিশেষ টেক্সট বা এরর রিটার্ন করে, তা এখানে ফিল্টার করতে পারেন।
    // আপাতত সিইউআরএল কানেক্ট হলে সাকসেস ধরা হচ্ছে।
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
