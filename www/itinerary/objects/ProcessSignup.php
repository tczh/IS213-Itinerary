<?php
    spl_autoload_register(
        function($class){
            require_once "model/$class.php";
        }
    );
    session_start();

    // var_dump($_GET["email"]);
    // var_dump($password = $_GET["password"]);
    // var_dump($_GET["first"]);
    // var_dump($_GET["last"]);
    // var_dump($_GET["country"]);

    // $userid = $_GET["userid"];
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
    // var_dump($country);

    // $email = "emflwk@gmail.com";
    // $password = "emflwk";
    // $first = 'Elvis';
    // $last = 'Leong';
    // $country = 'Iowa';

    // $dao = new UserDAO();
    // $success = false;

    // $url = "http://localhost:5013/user/$email";
    // $user = json_decode(file_get_contents($url))->data->user;

    if (isset($user->message)) {
        $_SESSION["existingemail"] = true;
        header("Location: ../signup.php");
    }

    else {
        // API URL
        $url = 'http://localhost:8000/api/v1/createuser';
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

        // $.ajax({
        //     type: 'POST',
        //     headers: {
        //         "Content-type": "application/json"
        //     },
        //     url: "http://localhost:5013/createuser",
        //     async: false,
        //     cache: false,
        //     data: {
        //         "emailaddr": jiaqi@gmail.com,
        //         "phonenumber": 777,
        //         "firstname": jiaqi,
        //         "lastname": chai,
        //         "password": jiaqi,
        //         "country": china,
        //         "address": wuhan,
        //         "role": user
        //     },
        //     success: function (jsonString) {
        //         var userData = JSON.parse(jsonString); // employeeData variable contains employee array.
        // });

        // var_dump('test');
        
        // <script type="text/javascript" onload="load()">
        // header("Location: ../success.html");
        // $count = $dao->generateUserId();
        // $user = $dao->register($userid, $email, $password, $first, $last, $country);

        // $url = 'http://localhost:5013/createuser';
        // // $data = array('emailaddr' => $email, 'phonenumber' => 11111, 'firstname' => $first, 'lastname' => $last, 'password' => $password, 'country' => $country, 'address' => 'temp', 'role' => 'user');

        // fetch('http://localhost:5013/createuser',
        //     {
        //         method: "POST",
        //         headers: {
        //             "Content-type": "application/json"
        //         },
        //         body: JSON.stringify({
        //             emailaddr: $email,
        //             phonenumber: 11111,
        //             firstname: $first,
        //             lastname: $last,
        //             password: $password,
        //             country: $country,
        //             address: 'temp',
        //             role: 'user'
        //         })
        //     })

        // use key 'http' even if you send the request to https://...
        // $options = array(
        //     'http' => array(
        //         'method'  => 'POST',
        //         'header'=> "Content-type: application/json",
        //         'content' => http_build_query($data)
        //     )
        // );
        // $context  = stream_context_create($options);
        // $result = file_get_contents($url, false, $context);
        // if ($result === FALSE) { 
        //     var_dump("failed");
        // }

        // var_dump($result);

        // if ($user) {
            // header("Location: ../success.html");
        // }
    }
?>

<script type="text/javascript">
    var URL = "http://localhost:8000/api/v1/createuser";
    var data = {
        "emailaddr": jiaqi@gmail.com,
        "phonenumber": 777,
        "firstname": jiaqi,
        "lastname": chai,
        "password": jiaqi,
        "country": china,
        "address": wuhan,
        "role": user
    }
    // Change serviceURL to your own
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Successfully created");
        }
    }
    request.open("POST",URL, false);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(data));
</script>