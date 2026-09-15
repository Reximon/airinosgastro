<?php
require 'config.php';

function refreshAccessToken() {
    if (!file_exists('token.json')) {
        die("No existe token.json. Primero autentica la app.");
    }
    $tokens = json_decode(file_get_contents('token.json'), true);
    if (!isset($tokens['refresh_token'])) {
        die("No hay refresh_token en token.json");
    }

    $refreshToken = $tokens['refresh_token'];

    $postFields = http_build_query([
        'grant_type' => 'refresh_token',
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => REDIRECT_URI,
        'refresh_token' => $refreshToken
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

    if ($httpCode != 200) {
        die("Error refrescando token. HTTP code: $httpCode. Response: $response");
    }

    $data = json_decode($response, true);

    if (isset($data['access_token'])) {
        if (!isset($data['refresh_token'])) {
            $data['refresh_token'] = $refreshToken;
        }
        file_put_contents('token.json', json_encode($data));
        return $data['access_token'];
    } else {
        die("Error al refrescar token.<br>" . print_r($data, true));
    }
}

function buscarEmpresas($accessToken, $zipQuery) {
    $url = "https://api.hubapi.com/crm/v3/objects/companies/search";

    $payload = json_encode([
        "filterGroups" => [[
            "filters" => [[
                "propertyName" => "zip",
                "operator" => "CONTAINS_TOKEN",
                "value" => $zipQuery
            ]]
        ]],
        "limit" => 20,
        "properties" => ["name", "zip"]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $accessToken",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return [$httpCode, $response];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zip = $_POST['zip'] ?? '';

    if (empty($zip)) {
        die('Debe enviar un código postal para buscar.');
    }

    if (!file_exists('token.json')) {
        die("No existe token.json. Primero autentica la app.");
    }

    $tokens = json_decode(file_get_contents('token.json'), true);
    $accessToken = $tokens['access_token'];

    list($httpCode, $response) = buscarEmpresas($accessToken, $zip);

    if ($httpCode == 401) {
        $accessToken = refreshAccessToken();
        list($httpCode, $response) = buscarEmpresas($accessToken, $zip);
    }

    if ($httpCode == 200) {
        $data = json_decode($response, true);
        echo "<h2>Resultados:</h2>";
        if (empty($data['results'])) {
            echo "No se encontraron empresas con código postal que contenga <strong>$zip</strong>.";
        } else {
            echo "<ul>";
            foreach ($data['results'] as $empresa) {
                $name = $empresa['properties']['name'] ?? '(Sin nombre)';
                $zipCode = $empresa['properties']['zip'] ?? '(Sin código)';
                echo "<li><strong>$name</strong> - Código postal: $zipCode</li>";
            }
            echo "</ul>";
        }
    } else {
        http_response_code($httpCode);
        echo "<strong>Error al hacer búsqueda:</strong><br>";
        echo "Código HTTP: $httpCode<br>";
        echo "Respuesta: <pre>$response</pre>";
    }
} else {
    ?>
    <h2>Buscar empresas por código postal</h2>
    <form method="POST">
        <label>Código postal contiene:</label>
        <input type="text" name="zip" required>
        <button type="submit">Buscar</button>
    </form>
    <?php
}
?>
