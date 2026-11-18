<?php
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Empty credentials"]);
    exit;
}

$loginUrl = "http://122.152.50.54:81/cnf_final/final/cms/admin/?app=admin&action=_login";

$postData = http_build_query([
    'data' => [
        'username' => $username,
        'password' => $password
    ]
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $loginUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);

// যদি লগইন সফল হয়, তবে সার্ভার সাধারণত 'msg=success' বা ড্যাশবোর্ড পেজে রিডাইরেক্ট করে
if (strpos($finalUrl, 'msg=success') !== false || (strpos($response, 'name="data[username]"') === false && !empty($response))) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "invalid"]);
}
?>
