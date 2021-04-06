<?php
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: index.php");
    }
?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Payment</title>
        <meta name="description" content="A demo of Stripe Payment Intents"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous">
        <link rel="stylesheet" href="css/create_itinerary.css">
        <link rel="stylesheet" href="css/normalize.css"/>
        <link rel="stylesheet" href="css/global.css"/>

        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script type='text/javascript' src="payment.js"></script>

		<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
		<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">

        <style>
			<?php include("includes/css.txt");?>
        </style>
    </head>

    <body style="background-color: rgb(233, 233, 233);" id="body_class" onload="retrieveLoad()">
		<?php include("includes/header.php");?>

        <!-- shopping cart header -->
        <div class="container" style="background-color: rgb(150, 150, 151); color: white; padding: 5px;margin-top: 68px">
            <div class="row">
                <div class="col">
                    <h4>Checkout</h4>
                </div>

            </div>
        </div>

        <div id= "payment_content">
            <div class="container border" style="margin-top: 30px;">
                <div class="row">
                    <div class=" col">
                        <h5>Order Summary</h5>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col ">
                        Itinerary purchased
                    </div>
                    <div class="col text-center">
                        <p id="quantity"></p>
                    </div>
                </div>
        
                <div class="row" id="summary">
                    <div class="col">
                        Total Price
                    </div>
                    <div class="col text-center" id="price">
                    </div>
                </div>
            </div>

            <div class="container border">
                <br>
                <div class="row">
                    <div class="col">
                        <label for="name">Name on Card</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <label for="email">Billing Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>

                <form id="payment-form" class="sr-payment-form">
                    <label for="card-element">Card Information</label>
                    <div class="sr-combo-inputs-row">
                        <div class="sr-input sr-card-element" id="card-element"></div>
                    </div>
                </form>

                <br>
                <button type="submit" id="submit" class="btn btn-primary w-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Submit</button>
                
                <!-- Modal -->
                <div class="modal fade" id="paymentModal" data-backdrop="static" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHeader"></h5>
                            </div>
                            <div class="modal-body">
                                <p id="modalBody"></p>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-primary" role="button" id="modalBtn"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<?php include("includes/footer.php");?>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>