<?php
    session_start();

    $email = $_GET["email"];
    $password = $_GET["password"];
    $first = $_GET["first"];
    $last = $_GET["last"];
    $phonenumber = $_GET["phonenumber"];
    $address = $_GET["address"];
    if ($_GET["country"] == "Country (Optional)") {
        $country = '';
    }
    else {
        $country = $_GET["country"];
    }

    if (isset($user->message)) {
        $_SESSION["existingemail"] = true;
        header("Location: ../signup.php");
    }

    else {
        // API URL
        $url = 'http://localhost:5013/createuser';
        // Create a new cURL resource
        $ch = curl_init($url);
        // Setup request to send json via POST
        $data = array(
            "emailaddr" => $email,
            "phonenumber" => $phonenumber,
            "firstname" => $first,
            "lastname" => $last,
            "password" => $password,
            "country" => $country,
            "address" => $address,
            "role" => 'user'
        );
        $payload = json_encode($data);
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute the POST request
        $result = curl_exec($ch);
        // Close cURL resource
        curl_close($ch);

        header("Location: ../success.php");
    }
?>