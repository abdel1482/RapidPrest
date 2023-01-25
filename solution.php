<html>

<head>
    <style>
    body {
        font-family: sans-serif;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px 0;
    }

    label {
        margin-bottom: 10px;
    }

    input[type="text"] {
        width: 300px;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        margin-top: 10px;
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #barcode {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    #barcode img {
        height: 50px;
    }
    </style>
</head>

<?php

// Set the API endpoint URL
$apiUrl = 'http://149.202.12.81/rapidprest_i2/public/api';

// Set the API key
$apiKey = 'sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w';

// Set the serial number of the machine
$serialNumber = '123456789';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $telephone = $_POST['telephone'];

    // Build the data array for the API call
    $data = array(
        'name' => $name,
        'amount' => $amount,
        'telephone' => $telephone,
        'serial_number' => $serialNumber
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

    // Make the API call
    $result = file_get_contents($apiUrl, false, $context);

    // Decode the response
    $response = json_decode($result);

    // Access the QR code from the response
    $qrCode = $response->qrCode;

    // Generate the QR code image
    header('Content-Type: image/png');
    echo base64_decode($qrCode);
} else {
    // Render the form
    ?>

<body>
    <form id="qr-form" method="post" onsubmit="return validateForm()">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="amount">Amount:</label><br>
        <input type="number" id="amount" name="amount"><br>
        <label for="telephone">Telephone:</label><br>
        <input type="tel" id="telephone" name="telephone"><br><br>
        <input type="submit" value="Submit">
    </form>

    <script>
    function validateForm() {
        // Get the form data
        var name = document.getElementById('name').value;
        var amount = document.getElementById('amount').value;
        var telephone = document.getElementById('telephone').value;

        // Validate the form data
        if (name == '' || amount == '' || telephone == '') {
            alert('All fields are required');
            return false;
        }
        if (isNaN(amount) || amount <= 0) {
            alert('Amount must be a valid number');
            return false;
        }
        if (!telephone.match(/^\d{10}$/)) {
            alert('Telephone must be a valid phone number');
            return false;
        }

        // If the form data is valid, submit the form
        return true;
    }
    </script>


</body>
<?php
}
?>

</html>