<?php
require 'config.php';
$url = "https://app.hubspot.com/oauth/authorize?client_id=" . CLIENT_ID .
       "&scope=" . SCOPES .
       "&redirect_uri=" . urlencode(REDIRECT_URI);
header("Location: $url");
exit;
