<html>

<head>
    <title>RapidPrest API 0.3</title>
</head>

<body>
    <?php

    // Set the API endpoint URL supposedly that the availbility is checked :OK
    $apiUrl = 'http://149.202.12.81/rapidprest_i2/public/api/';

    // Set the API key
    $apiKey = 'sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w';


    function generateCodigo($url, $apiKey)
    {
        // Set up the cURL request array
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $apiKey
                ),
            )
        );

        // Execute the cURL request
        $response = curl_exec($curl);

        curl_close($curl);

        // Return the response to be treated after this
        return $response;
    }
    // Get the amount from the form
    $amount = $_POST['amount'];

    $generarqr = 'maq1/generarqr/prueba1';
    $leerqr = 'maq2/leerqr/prueba1';

    $Numeroautorizacion = 111;

    $urlgenerarqr = $apiUrl . $generarqr . '?cantidad=' . $amount . '&numeroautorizacion=' . $Numeroautorizacion;

    // Generate the data
    $data = generateCodigo($urlgenerarqr, $apiKey);

    // Check if the state is 200
    if (json_decode($data)->state == 200) {
        // State is 200, display the codigo code
        $codigo = json_decode($data)->data->codigo;
        echo 'the code codigo is : ' . $codigo;

    } else {
        // State is not 200, display the error code
        $error_code = 101;

        switch ($error_code) {
            case 101:
                echo 'Error code ' . $error_code . ': Local Inactivo';
                break;
            case 102:
                echo 'Error code ' . $error_code . ': Maquina Bloqueada';
                break;
            case 103:
                echo 'Error code ' . $error_code . ': Banco no operativo';
                break;
            case 107:
                echo 'Error code ' . $error_code . ': Usuario Incorrecto (api key no correcta)';
                break;
            case 108:
                echo 'Error code ' . $error_code . ': Parametros de entrada no validos';
                break;
            case 111:
                echo 'Error code ' . $error_code . ': Local con saldo insuficiente';
                break;
            case 112:
                echo 'Error code ' . $error_code . ': Local con creditos insuficiente';
                break;
            case 113:
                echo 'Error code ' . $error_code . ': Maquina no del usuario';
                break;
            default:
                echo 'Error code ' . $error_code . ': Error code not recognized';
                break;
        }

        $codigo = NULL;
    }
    echo '<br/><br/><br/>';
    $urleerqr = $apiUrl . $leerqr . '?codigo=' . $codigo;

    $answer = generateCodigo($urleerqr, $apiKey);

    // Check if the state is 200
    if (json_decode($answer)->state == 200) {
        // State is 200, display the codigo code
        $leerqr = json_decode($answer)->data;
        echo 'The leerqr array data is : ' . $leerqr;

    } else {
        // State is not 200, display the error code
        $error_code = 101;

        switch ($error_code) {
            case 101:
                echo 'Error code ' . $error_code . ': Local Inactivo';
                break;
            case 102:
                echo 'Error code ' . $error_code . ': Maquina Bloqueada';
                break;
            case 104:
                echo 'Error code ' . $error_code . ': Codigo QR no existente';
                break;
            case 105:
                echo 'Error code ' . $error_code . ': Este código QR no pertenece a este local';
                break;
            case 106:
                echo 'Error code ' . $error_code . ': Codigo QR ya consumido';
                break;
            case 107:
                echo 'Error code ' . $error_code . ': Usuario Incorrecto (api key no correcta)';
                break;
            case 108:
                echo 'Error code ' . $error_code . ': Parametros de entrada no validos';
                break;
            case 110:
                echo 'Error code ' . $error_code . ': Makina con billetes insuficientes';
                break;
            case 111:
                echo 'Error code ' . $error_code . ': Local con saldo insuficiente';
                break;
            case 113:
                echo 'Error code ' . $error_code . ': Maquina no del usuario';
                break;
            case 114:
                echo 'Error code ' . $error_code . ': Codigo QR caducado';
                break;
            default:
                echo 'Error code ' . $error_code . ': Error code not recognized';
                break;
        }

    }

    ?>
</body>

</html>