<html>

<head>
    <title>RapidPrest API 0.3</title>
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

<body>
    <form id="qr-form" action="treatment.php" method="post" onsubmit="return validateForm()">
        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="amount">Cantidad:</label><br>
        <input type="number" id="amount" name="amount"><br>
        <label for="telephone">Teléfono:</label><br>
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

</html>