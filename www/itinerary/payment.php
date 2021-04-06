<?php
    // if (isset($_SESSION["email"])) {
        //$username = $_SESSION["email"];
    session_start();
    $_SESSION["email"] = "yuhao.neo.2019@sis.smu.edu.sg";
    // } else {
    //     header("Location: home.php");
    // }
?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Payment</title>
        <meta name="description" content="A demo of Stripe Payment Intents"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/create_itinerary.css">
        <link rel="stylesheet" href="./css/normalize.css"/>
        <link rel="stylesheet" href="./css/global.css"/>

        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script type='text/javascript' src="payment.js"></script>

        <style>
            div nav a:link {
                color: white;
                text-decoration: none;
            }
    
            div nav a:visited {
                color: white;
                text-decoration: none;
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

            .footer .social>* {
                margin-left: 15px;
                margin-right: 15px;
            }

            .bg-dark {
                background: #333;
                color: #fff;
            }
        </style>
    </head>

    <body style="background-color: rgb(233, 233, 233);" id="body_class" onload="retrieveLoad()">
        <nav id="navbar" class="navbar top fixed-top navbar-dark bg-dark navbar-expand-lg">
            <!-- Navbar content -->
            <a class="navbar-brand" href="index.php">
                <span class="text-warning"><i class="fas fa-globe-americas fa-2x"></i></span>
                <span class="text-warning">Tim's</span> Travel Agent
            </a>

            <button class='navbar-toggler' data-toggle='collapse' data-target='#myMenu'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="myMenu">
                <div class='navbar-nav'>
                    <!-- Need to update href links when they are ready -->
                    <a class='nav-item nav-link text-white' href=index.php>Home</a>
                    <a class='nav-item nav-link text-white' href=about.php>About</a>
                    <div id='profile'></div>
                    <div id='createitinerary'></div>
                    <div id='cart'></div>
                    <a class='nav-item nav-link text-white' href="#" id="logout"></a>
    
    
                    <!-- <script>
                        console.log(sessionStorage['userid']);
    
                        var emptyHtml = '';
                        var createitinerary = '';
                        var cart = '';
                        if (sessionStorage['userid']) {
                            console.log(sessionStorage['userid']);
                            // sessionStorage.clear();
                            emptyHtml +=
                                `<a class='nav-item nav-link text-white' id="profilepage" href='ProfilePage.php'>Profile</a>`;
                            createitinerary +=
                                `<a class='nav-item nav-link text-white' id="createitinerary" href='create_itinerary.html'>Create Itinerary</a>`;
                            cart += `<a class='nav-item nav-link text-white' id="cart" href='checkout.html'>Cart</a>`;
                            document.getElementById('profile').innerHTML = emptyHtml;
                            document.getElementById('createitinerary').innerHTML = createitinerary;
                            document.getElementById('cart').innerHTML = cart;
                            document.getElementById("logout").setAttribute('href', "objects/ProcessLogout.php");
                            document.getElementById("logout").innerText = "Logout";
                            document.getElementById("body_class").setAttribute("onload",
                                "purchasesby_id(); list_of_year(); list_of_month()");
    
                        }
                    </script> -->
                </div>
            </div>
        </nav>

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

        <br><br>
        
        <!-- Modal -->
        
        <div id="insert_modal"></div>
        
        <footer class="footer bg-dark">
            <div class="social">
                <a href="#"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="#"><i class="fab fa-twitter fa-2x"></i></a>
                <a href="#"><i class="fab fa-youtube fa-2x"></i></a>
                <a href="https://www.linkedin.com/in/timothy-chia-a23858100/"><i class="fab fa-linkedin fa-2x"></i></a>
            </div>
            <p>Copyright &copy; 2020 - Tim's Travel Agent</p>
        </footer>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>