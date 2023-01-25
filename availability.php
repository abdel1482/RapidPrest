<?php

// Set the API endpoint URL
$apiUrl = 'http://149.202.12.81/rapidprest_i2/public/api/maq/comprueba_disponibilidad/prueba1';

// Set the API key
$apiKey = 'sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w';

// Set the headers for the request
$headers = array(
    'Content-Type: application/x-www-form-urlencoded',
    "X-API-Key: $apiKey"
);

// Build the options array for the request
$options = array(
    'http' => array(
        'header' => $headers,
        'method' => 'GET'
    )
);

// Create the context for the request
$context = stream_context_create($options);

// Send the request
$result = file_get_contents($apiUrl, false, $context);

// Check the status code of the response
if (http_response_code() == 200) {
    // API is available
    echo "the server is availble";
} else {
    // API is not available
    // Handle the error
    echo "the server is not availble";
    var_dump(http_response_code());
}
?>