<html>

<head>
    <title>QR Code Generator</title>
</head>

<body>
    <?php

    // Set the API endpoint URL supposedly that the availbility is checked :OK
    $apiUrl = 'http://149.202.12.81/rapidprest_i2/public/api/maq1/generarqr/prueba1';

    // Set the API key
    $apiKey = 'sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w';

    // Set the Numeroautorization
    $Numeroautorization = 'test';

    function sendRequest()
    {
        global $apiUrl, $apiKey, $Numeroautorization;
        $apiUrl .= "?Numeroautorización=$Numeroautorization";
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "apikey: $apiKey",
            "Numeroautorization: $Numeroautorization"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
    function Mehdi($amount)
    {

        $curl = curl_init();
        $url = 'http://149.202.12.81/rapidprest_i2/public/api/maq1/generarqr/prueba1' . '?cantidad=' . $amount . '&numeroautorizacion=111';

        curl_setopt_array(
            $curl,
            array(
                // CURLOPT_URL => 'http://149.202.12.81/rapidprest_i2/public/api/maq1/generarqr/prueba1?cantidad=110&numeroautorizacion=111',
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function generateDataBycURL($amount)
    {
        global $apiUrl, $apiKey, $Numeroautorization;

        // Build the data array for the API call
        $data = array(
            'amount' => $amount
        );

        // Set up the cURL request
        $apiUrl .= "?Numeroautorización=$Numeroautorization";
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt(
        //     $ch,
        //     CURLOPT_HTTPHEADER,
        //     array(
        //         "Content-type: application/x-www-form-urlencoded",
        //         "X-API-Key: $apiKey",
        //         "Numeroautorization: $Numeroautorization"
        //     )
        // );
    
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "Content-type: application/json",
                "X-API-Key: $apiKey",
            )
        );

        // Execute the cURL request
        $result = curl_exec($ch);

        // Decode the response
        $response = json_decode($result);

        // Return the data from the response
        return $response->data;
    }
    function generateData($amount)
    {
        global $apiUrl, $apiKey, $Numeroautorization;

        // Build the data array for the API call
        $data = array(
            'Cantidad' => $amount,
            'Numeroautorización' => $Numeroautorization
        );

        // Build the options array for the API call
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                "X-API-Key: $apiKey\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );

        // Create the context for the API call
        $context = stream_context_create($options);


        // Add the Numeroautorization to the URL Because I tested it inside the header andit didn't work
        $apiUrl .= "?Numeroautorización=$Numeroautorization";

        // Make the API call
        $result = file_get_contents($apiUrl, false, $context);

        // Decode the response
        $response = json_decode($result);

        // Return the data from the response
        return $response->data;
    }
    // Get the amount from the form
    $amount = $_POST['amount'];

    // Generate the data
    $data = generateDataBycURL($amount);
    $mehdi = Mehdi($amount);

    echo $mehdi;
    $resuest = sendRequest();
    //place all response inside a txt file for visualisation
    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $data);
    fwrite($myfile, "\n=============================cURL===================================\n");
    fwrite($myfile, $resuest);
    fwrite($myfile, "\n============================Mehdi====================================\n");
    fwrite($myfile, $mehdi);
    fclose($myfile);


    // Check if the state is 200
    if ($data->state == 200) {
        // State is 200, display the QR code
        echo '<img src="data:image/png;base64,' . $data->data->codigo . '" alt="QR Code">';
    } else {
        // State is not 200, display the error message
        echo 'Error: ' . $data->state;
    }
    ?>
</body>

</html>