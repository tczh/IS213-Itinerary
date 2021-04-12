<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous"/>

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
               margin-top: 30px;
               margin-bottom: 30px;
               min-width: 450px;
        }

        #title {
            text-align: center;
            margin-top: 100px;
        }
        
        #slogan {
            text-align: center;
        }


        h1 {
            margin-top: 100px;
            text-align: center;
        }
        #box p {
            margin-top: 80px;
            text-align: center;
            margin-bottom: 100px;
        }

        #box {
            border: 1px solid black;
            padding: 50px;
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

    <title>Account Creation Success</title>
</head>
<body>
    <?php include("includes/header.php");?>
    <div class="marginbox">

    <div id="box">
        <h1>Account Successfully Created!</h1>
        <p>Click <a href="login.php">here</a> to log in</p>
    </div>
</div>

<?php include("includes/footer.php");?>

</body>
</html>