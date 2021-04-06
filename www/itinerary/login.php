<?php
    session_start();
    if (isset($_SESSION["emailaddr"])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="953122174200-40p78h9am9pgl6jda81e024bnmjui7p5.apps.googleusercontent.com">
    <title>Login Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous"/>

    <!-- Custom JavaScript -->
    <script src="login.js"></script>

    <!-- Google Sign-In -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <style>
        * {
               margin: 0;
        }

        .marginbox {
               width: 50%;
               margin: auto;
               margin-bottom: 140px;
               min-width: 450px;
        }

        #title {
            text-align: center;
            margin-top:100px;
        }
        
        #slogan {
            text-align: center;
        }



        #form {
            border: 1px solid black;
            padding: 50px;
        }

        #create {
            text-align: center;
        }

        .red {
            color: red;
        }

        button {
            margin-bottom: 16px;
        }

        .motto {
            font-style: italic;
            font-size: 15px;
            margin-left: 5px;
        }

        .navbar {
            opacity: 0.8;
            position: fixed;
            top: 0px;
        }

        .navbar.top {
            background: transparent;
        }

        .navbar-nav a:hover {
            border-bottom: #f0ad4e 2px solid;
        }

        .nav-item {
            margin-right: 20px;
        }

        /* Footer */
        .footer {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 200px;
        }

        .footer a {
            color: #fff;
        }

        .footer a:hover {
            color: #f0ad4e;
        }

        .footer .social > * {
            margin-left: 15px;
            margin-right: 15px;
        }

        .bg-dark {
            background: #333;
            color: #fff;
        }

    </style>
</head>
<body onload='init()'>
<div class="marginbox">
<nav id="navbar" class="navbar top fixed-top navbar-dark bg-dark navbar-expand-md">
        <!-- Navbar content -->
        <a class="navbar-brand" href="index.php"><span class="text-warning">Tim's</span> Travel Agent
        <span class="text-warning"><i class="fas fa-globe-americas fa-2x"></i></span><em class="motto">Where your itineraries come to life</em>
        </a>

        <button class='navbar-toggler' data-toggle ='collapse' data-target='#myMenu'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="myMenu">
            <div class='navbar-nav'>
                <!-- Need to update href links when they are ready-->
                <a class='nav-item nav-link text-white' href=index.php>Home</a>
                <a class='nav-item nav-link text-white' href=about.php>About</a>
                <?php
                if (!isset($_SESSION["emailaddr"])) {
                    echo "<a class='nav-item nav-link text-white' href='login.php'>Login</a>";
                }
                else {
                    echo "<a class='nav-item nav-link text-white' href='#'>Profile</a>";
                }
                ?>

                <a class='nav-item nav-link text-white' href=#>Cart</a>

                <?php
                    if (isset($_SESSION["emailaddr"])) {
                        echo "<a class='nav-item nav-link text-white' href='objects/ProcessLogout.php'>Log Out</a>";
                    }
                ?>
            </div>
        </div>
    </nav>

    <h1 id="title">
        Tim's Travel Agent
   </h1>

    <p id="slogan">
        Where your itineraries come to life
    </p>

    <form id="form" action='objects/ProcessLogin.php' method='GET'>
        
        <?php
            if (isset($_SESSION['check']) and $_SESSION['check'] == false) {
                echo "<p class='red'>Incorrect Username or Password</p>";
                unset($_SESSION['check']);
            }
            if (isset($_SESSION['nopassword']) and $_SESSION['nopassword'] == true) {
                echo "<p class='red'>Please enter a password</p>";
                unset($_SESSION['nopassword']);
            }
        ?>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="email">Email</span>
            </div>
            <input type="text" id="emailinput" name='email' class="form-control" placeholder="Example: abc@xyz.com" aria-label="email" aria-describedby="email">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="password">Password</span>
            </div>
            <input type="password" id="passwordinput" name='password' class="form-control" aria-label="password" aria-describedby="password">
        </div>

        <button type="submit" disabled class="btn btn-info btn-block">Log In</button>

        <div class="g-signin2" data-onsuccess="onSignIn"></div>
    </form>

    <p id='create'><a href='signup.php'>Create an account</a></p>
</div>

    <footer class="footer bg-dark">
      <div class="social">
        <a href="#"><i class="fab fa-facebook fa-2x"></i></a>
        <a href="#"><i class="fab fa-twitter fa-2x"></i></a>
        <a href="#"><i class="fab fa-youtube fa-2x"></i></a>
        <a href="https://www.linkedin.com/in/timothy-chia-a23858100/"><i class="fab fa-linkedin fa-2x"></i></a>
      </div>
      <p>Copyright &copy; 2020 - Tim's Travel Agent</p>
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript">
        $("#passwordinput").keyup(function(event) {
            validateInputs();
        });
    
        $("#emailinput").keyup(function(event) {
            validateInputs();
        });
    
        function validateInputs(){
            var disableButton = false;
    
            var val1 = $("#passwordinput").val();
            var val2 = $("#emailinput").val();
    
            if(val1.length == 0 || val2.length == 0)
                disableButton = true;
    
            $('button').attr('disabled', disableButton);
        }
    </script>

</body>
</html>