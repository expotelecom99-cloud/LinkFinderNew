<?php
header('Content-Type: application/json');

$username =$_POST['username'] ?? '';
$password =$_POST['password'] ?? '';

if (empty($username) \vert{}\vert{} empty($password)) {
    echo json_encode(["status" => "error", "message" => "Empty credentials"]);
    exit;
}

// আপনার সার্ভারের আসল লগইন অ্যাকশন URL
\$loginUrl = "http://122.152.50.54:81/cnf_final/final/cms/admin/?app=admin&action=_login";

// সার্ভারের ফর্ম অনুযায়ী ঠিক একই নামে POST ডেটা সাজানো হলো
\$postData = http_build_query([
    'data' => [
        'username' => \$username,
        'password' => \$password
    ]
]);

\$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$loginUrl);
curl_setopt(\$ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt(\$ch, CURLOPT_FOLLOWLOCATION, true); // রিডাইরেক্ট ফলো করবে
curl_setopt(\$ch, CURLOPT_COOKIEJAR, ''); // সেশন কুকি হ্যান্ডেল করার জন্য
curl_setopt(\$ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // লগইনের পর কোন URL-এ গেল তা দেখবে
$error = curl_error($ch);
curl_close(\$ch);

if (\$response === false) {
    echo json_encode(["status" => "connection_error", "message" => \$error]);
    exit;
}

// লগইন সফল হলে সার্ভার msg=success লিংকে নিয়ে যায় অথবা পেজে আর লগইন ফর্ম (data[username]) থাকে না
if (strpos($finalUrl, 'msg=success') !== false \vert{}\vert{} strpos($response, 'name="data[username]"') === false) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "invalid"]);
}
?>
