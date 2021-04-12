<?php
    session_start();
    if (isset($_SESSION["email"])) {
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

	<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
        * {
               margin: 0;
        }

        .marginbox {
               width: 50%;
               margin: auto;
			   margin-top: 50px;
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

        .bg-dark {
            background: #333;
            color: #fff;
        }

		<?php include("includes/css.txt");?>
    </style>
</head>
<body onload='init()'>
<?php include("includes/header.php");?>

<div class="marginbox">

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

	<?php include("includes/footer.php");?>

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