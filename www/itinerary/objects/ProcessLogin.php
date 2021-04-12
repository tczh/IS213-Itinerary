<?php
    spl_autoload_register(
        function($class){
            require_once "model/$class.php";
        }
    );

    session_start();
    $email = $_GET["email"];
    $password = $_GET["password"];
    if ($password == "" and (!isset($_GET['google']))) {
        $_SESSION["nopassword"] = true;
        header("Location: ../login.php");
    }
    if (isset($_GET['google'])) {
        $google = $_GET['google'];
    }

    $url = "http://localhost:8000/api/v1/user";
    $users = json_decode(file_get_contents($url))->data->user;
    $primary = "";

    for ($i=0; $i<count($users);$i++) {
        if ($users[$i]->emailaddr == $email) {
            $primary = $users[$i];
        }
    }
    if($primary!="") {
        if ($primary->password == $password) {
            $_SESSION["email"] = $primary->emailaddr;
            $_SESSION["role"] = $primary->role;
            $_SESSION["check"] = true;
            if ($primary->role == "user") {
                header("Location: ../index.php");
            }
            else {
                header("Location: ../approve.php");
            }
        }
        else {
            $_SESSION["check"] = false;
            header("Location: ../login.php");
        }
    }
    
    elseif (isset($google)) {
        $_SESSION["email"] = $email;
        $_SESSION["check"] = true;
        if ($primary!= "") {
            $_SESSION["email"] = $primary->emailaddr;
            $_SESSION["role"] = 'user';
            header("Location: ../index.php");
        }
        else {
            $url = 'http://localhost:8000/api/v1/createuser';
            // Create a new cURL resource
            $ch = curl_init($url);
            // Setup request to send json via POST
            $data = array(
                "emailaddr" => $email,
                "phonenumber" => "",
                "firstname" => $_GET['first'],
                "lastname" => $_GET['last'],
                "password" => "",
                "country" => "",
                "address" => "",
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

        header("Location: ../success.html");
            # microservice to sign up
            header("Location: ../index.php");
        }
    }

    elseif ($password != "") {
        $_SESSION["check"] = false;
        ?>
        <script type="text/javascript">
        window.location.href = 'http://localhost/itinerary/login.php';
        </script>
        <?php
    }
?>
