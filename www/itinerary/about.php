<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
        * {
               margin: 0;
               padding: 0;
        }

        .motto {
            font-style: italic;
            font-size: 15px;
            margin-left: 5px;
        }  

        /* About Info */
        #about-info {
            margin-top: 100px;
        }

        #about-info .info-left {
            min-height: 100%;
        }

		.bg-dark {
            background: #333;
            color: #fff;
        }

        /* Testimonials */
        #testimonials {
            height: 600px;
            background: url('images/LA.jpg') no-repeat center center/cover;
            padding-top: 100px;
        }

        #testimonials h2 {
            color: #fff;
            text-align: center;
            padding-bottom: 40px;
        }

        #testimonials .testimonial {
            padding: 20px;
            margin-bottom: 40px;
            border-radius: 5px;
            opacity: 0.8;
        }

        #testimonials .testimonial img {
            width: 100px;
            float: left;
            margin-right: 20px;
            border-radius: 50%;
        }

        .testimonial {
            min-height: 140px;
        }

        /* Utility Classes */
            .container {
            margin: auto;
            max-width: 1100px;
            overflow: auto;
            padding: 0 20px;
        }

        <?php include("includes/css.txt");?>

    </style>
</head>
<body>
	<?php include("includes/header.php");?>

    <section id="about-info" class="py-3">
        <div class="container">
          <div class="info-left">
            <h1 class="l-heading"><span class="text-warning">About</span> Odyssey</h1>
            <p>To allow travellers to be able to upload their past itineraries for different locations. In return, they get a small fee when another person purchases their itineraries. The website would be a one-stop portal for travellers to be able to look through other travellers’ itineraries. This helps them save time having to plan their inteinary. With this solution, it targets travellers who are too busy to plan their itinerary but wishes to go on a free and easy trip.</p>
            <p>People prefer to go on a free and easy trip instead of travelling with a tour agency. Free and easy trips grants them more flexibility allowing them to adjust their trip according to their liking. However, planning for a trip requires a lot of work, from searching for the accommodation to deciding on the attraction to visit. The itineraries plan is often left aside after the trip. 
                Hence, the main purpose of our project is to allow busy travellers to gain access to existing itineraries while not letting itineraries that others planned go to waste. 
                </p>
          </div>
        </div>
      </section>

      <div class="clr"></div>

    <section id="testimonials" class="py-3">
        <div class="container">
            <h2 class="text-dark">What Our Customers Say</h2>
            <div class="testimonial bg-dark">
                <img src="images/Timothy.jpg" alt="Tim">
                <h4>Thanks Odyssey for this dope app!</h4>
            </div>
        </div>
    </section>
    
	<?php include("includes/footer.php");?>
</body>
</html>