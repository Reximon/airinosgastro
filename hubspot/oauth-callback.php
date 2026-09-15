<?php
require 'config.php';

if (!isset($_GET['code'])) {
    die('No code provided');
}

$code = $_GET['code'];

// Crear el cuerpo URL-encoded
$postFields = http_build_query([
    'grant_type' => 'authorization_code',
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
    'redirect_uri' => REDIRECT_URI,
    'code' => $code
]);

$ch = curl_init('https://api.hubapi.com/oauth/v1/token');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP code: $httpCode<br>";
echo "Response:<br><pre>$response</pre>";

$data = json_decode($response, true);

if (isset($data['access_token'])) {
    file_put_contents('token.json', json_encode($data));

} else {
    echo "Error al obtener token.<br>";
    echo "<pre>" . print_r($data, true) . "</pre>";
}
?>
