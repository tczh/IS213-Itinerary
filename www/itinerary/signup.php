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
    <title>Sign Up</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous"/>

    <!-- Custom JavaScript -->
    <script src="signup.js"></script>

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
               margin-bottom: 61px;
               min-width: 450px;
        }

        #title {
            text-align: center;
            margin-top: 100px;
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

        .right-align {
            text-align: right;
        }

        .red {
            color: red;
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

        .col-md, #country-dropdown {
            margin-bottom: 16px;
        }

		<?php include("includes/css.txt");?>
    </style>
</head>
<body onload="dropdown_populate()">
<?php include("includes/header.php");?>
<div class="marginbox">
    <?php
        if (isset($_SESSION["existingemail"])) {
            echo "<p class='red'>
                Email already exist.
            </p>";
        }
        unset($_SESSION["existingemail"]);
    ?>

    <div id="passwordValidation"></div>

    <form id="form" action="objects/ProcessSignup.php" method='GET'>
        <p>
            Create your Odyssey Account
        </p>

        <div class="row dual-form">
            <div class="col-md">
                <input type="text" id="first" name='first' class="form-control" placeholder="First name">
            </div>
            <div class="col-md">
                <input type="text" id="last" name='last' class="form-control" placeholder="Last name">
            </div>
        </div>

        <input type="email" name='email' class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>

        <input type="number" name='phonenumber' class="col-md form-control" id="phonenumber" placeholder="Enter Phone Number">
        
        <input type="text" name='address' class="col-md form-control" id="address" placeholder="Enter Address">
        

        <div id="country"></div>

        <div class="row dual-form">
            <div class="col-md">
                <input type="password" id="password" name='password' class="form-control" placeholder="Password">
            </div>
            <div class="col-md">
                <input type="password" id="confirmpassword" name='confirmpassword' class="form-control" placeholder="Confirm Password">
            </div>
        </div>
                <button type="submit" id="submit" disabled class="btn btn-info btn-block">Sign Up</button>


    </form>
    </div>
	
	<?php include("includes/footer.php");?>
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $("#first").keyup(function(event) {
            validateInputs();
        });
    
        $("#last").keyup(function(event) {
            validateInputs();
        });

        $("#email").keyup(function(event) {
            validateInputs();
        });
    
        $("#password").keyup(function(event) {
            validateInputs();
        });

        $("#confirmpassword").keyup(function(event) {
            validateInputs();
        });
    
        function validateInputs(){
            var disableButton = false;
    
            var val1 = $("#first").val();
            var val2 = $("#last").val();
            var val3 = $("#email").val();
            var val4 = $("#password").val();
            var val5 = $("#confirmpassword").val();
    
            if(val1.length == 0 || val2.length == 0 || val3.length == 0 || val4.length == 0 || val5.length == 0 || val4 != val5)
                disableButton = true;
    
            $('button').attr('disabled', disableButton);

            if (val4 != val5)
                document.getElementById('passwordValidation').innerHTML = "<p class='red'>Password don't match</p>"
            else
                document.getElementById('passwordValidation').innerHTML = ""
        }
    </script>
</body>
</html>