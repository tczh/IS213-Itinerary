<?php
    spl_autoload_register(
        function($class){
            require_once "model/$class.php";
        }
    );

    session_start();
    // unset($SESSION['check']);
    $email = $_GET["email"];
    $password = $_GET["password"];
    if ($password == "" and (!isset($_GET['google']))) {
        $_SESSION["nopassword"] = true;
        header("Location: ../login.php");
    }
    // var_dump(isset($_GET['google']));
    if (isset($_GET['google'])) {
        $google = $_GET['google'];
    }

    $url = "http://localhost:8000/api/v1/user";

    // var_dump($email);
    // var_dump($url);

    $users = json_decode(file_get_contents($url))->data->user;

    // var_dump('test');
    // var_dump($users);

    // var_dump(isset($user->message));
    // var_dump($user->password == $password);

    $primary = "";

    for ($i=0; $i<count($users);$i++) {
        // var_dump($users[$i]->emailaddr);
        if ($users[$i]->emailaddr == $email) {
            $primary = $users[$i];
        }
    }

    // var_dump($primary);

    // alert();

    // $dao = new UserDAO();
    // $user = $dao->retrieve($email);
    // $success = false;
    if($primary!="") {
        // var_dump(!isset($primary->message));
        if ($primary->password == $password) {
        // $hashed = $user->getHashedPassword();
        // $success = password_verify($password,$hashed); 
        // if () {
        // if($success){
            // var_dump($user->getUserId());
            $_SESSION["email"] = $primary->emailaddr;
            $_SESSION["role"] = $primary->role;
            // $_SESSION["fullname"] = 
            $_SESSION["check"] = true;
            // var_dump('test');
            // var_dump('testtt');
            if ($primary->role == "user") {
                header("Location: ../index.php");
            }
            else {
                header("Location: ../approve.php");
            }
            // var_dump($_SESSION["email"]);
        // }
        }
        else {
            $_SESSION["check"] = false;
            header("Location: ../login.php");
        }
    }
    
    elseif (isset($google)) {
        // var_dump($google);
        // var_dump("shit");
        $_SESSION["email"] = $email;
        $_SESSION["check"] = true;
        // $dao = new UserDAO();
        // $count = $dao->generateUserId();
        // $_SESSION["userid"] = $email;
        // $user = $dao->retrieve($email);
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
            // $user = $dao->register($email, $email, "", $_GET["first"], $_GET["last"], "");
            # microservice to sign up!!!!!!!!!!!!!!!!!!!!!!!!!
            header("Location: ../index.php");
            // var_dump('test');
        }
    }

    elseif ($password != "") {
        // var_dump('testtt');
        $_SESSION["check"] = false;
        // unset($_SESSION['email']);
        // header("Location: ../login.php");
        ?>
        <script type="text/javascript">
        window.location.href = 'http://localhost/itinerary/login.php';
        </script>
        <?php
        // var_dump('test');
    }
?>
