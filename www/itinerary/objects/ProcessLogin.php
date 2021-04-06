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
    var_dump(isset($_GET['google']));
    if (isset($_GET['google'])) {
        $google = $_GET['google'];
    }

    $url = "http://localhost:5013/user/$email";

    var_dump($email);
    var_dump($url);

    $user = json_decode(file_get_contents($url))->data->user;

    // var_dump($user);

    var_dump(isset($user->message));
    var_dump($user->password == $password);

    // alert();

    // $dao = new UserDAO();
    // $user = $dao->retrieve($email);
    // $success = false;
    if((!isset($user->message)) && ($user->password == $password)){
        // $hashed = $user->getHashedPassword();
        // $success = password_verify($password,$hashed); 
        // if () {
        // if($success){
            // var_dump($user->getUserId());
            $_SESSION["emailaddr"] = $user->emailaddr;
            // $_SESSION["fullname"] = 
            $_SESSION["check"] = true;
            // var_dump('test');
            // var_dump('testtt');
            if ($user->role == "user") {
                header("Location: ../index.php");
            }
            else {
                header("Location: ../approve.php");
            }
            // var_dump($_SESSION["email"]);
        // }
    }
    
    elseif (isset($google)) {
        var_dump($google);
        $_SESSION["emailaddr"] = $email;
        $_SESSION["check"] = true;
        // $dao = new UserDAO();
        // $count = $dao->generateUserId();
        // $_SESSION["userid"] = $email;
        // $user = $dao->retrieve($email);
        if (len($user)>1) {
            $_SESSION["emailaddr"] = $user->emailaddr;
            header("Location: ../index.php");
        }
        else {
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
