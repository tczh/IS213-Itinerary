<?php
        session_start();
        // to change
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItineraryPage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Didact+Gothic' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style>
        .highlight {
            background: url(https://www.andyhooke.co.uk/wp-content/uploads/2018/02/yellow-brushstroke.png);
            background-repeat: no-repeat;
            background-size: 100% 100%;
            padding: 1px 0;
        }

        .highlight2 {
            background: url("brush-stroke-banner-3.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 90% auto;
            padding: 8px 0;
            color: white;
        }

        .box1{
            background-color:white; 
            margin-top: 15px;
            margin-left:15px;
            margin-right:15px;
            margin-bottom:25px;
            border-radius:5px;
            background-color: #EBA39E;
            padding: 10px;
            overflow:hidden;
            word-wrap: break-word;
        }

        .box1 h3{
            font-family: 'Didact Gothic', sans-serif;
            font-weight:normal;
            text-align:center;
            color:#fff;
        }
		
        .shadow1{
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

		<?php include("includes/css.txt");?>
    </style>
</head>

<body>
	<?php include("includes/header.php");?>

    <div class="container" id="app">
        <div class='row'>
            <?php
            /* TO CHANGE MAYBE */
                $itineraryid = $_GET['itineraryid'];
                if(isset($_SESSION['email'])) {
                    $userid = $_SESSION['email'];
                } else {
                    $userid = 0;
                }

            ?>
            <div class="col-sm-12 text-center" style="background:white;" v-if="error != 1">
                <img :src="thumbnail" style="width:100%;height:300px;object-fit:cover;">
                
                <h2 class='highlight2 text-center'>{{tourtitle}}</h2>
                <h3>Experience {{season}} in {{country}}</h3>
                <div v-if="reviewCheck = 1">
                    <span v-if="averageRating >=4.75">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=4.25">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star-half fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=3.75">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=3.25">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star-half fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=2.75">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=2.25">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star-half fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=1.75">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=1.25">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star-half fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=0.75">
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                        <i class='fa fa-star fa-lg' style='color:yellow'></i>
                    </span>
                    <span v-else-if="averageRating >=0.25">
                        <i class='fa fa-star-half fa-lg' style='color:yellow'></i>
                    </span>
                    <br>
                    <span style='font-size:14px;font-variant:small-caps'>Average Rating: {{averageRating}}/5</span>
                </div>               
                <hr>
            </div>
            <!--Body-->
            <div class="col-sm-8 text-center" v-if="error != 1">
                <h3 class='highlight2'>Preview of Activities</h3>
                <br>
                <h4 class='text-left' style="font-variant:small-cap"><span class='highlight'>&nbsp&nbsp&nbsp Day 1 &nbsp&nbsp</span></h4>
                <div class ="box1 shadow1" v-for="activities in detailsArray">
                    <h3>{{activities["activity"]}}</h3>
                    <i class="fa fa-map-marker" style='color:red'></i> {{activities['location']}} <br>
                    <i class="fa fa-clock-o" style='color:green'></i> {{activities['timestart']}} - {{activities['timeend']}} <br>
                    <br>
                    {{activities['description']}}
                    <br><br>
                </div>
                <div>
                    ...<br>
                    Your preview ends here
                </div>
                <br><br><br>
                <hr>
                <h2 class='highlight2' style='margin-top:30px'>Reviews</h2>
                <div v-if="reviewError != ''">This itinerary has not been reviewed yet</div>
                <div v-else>
                    <div class='text-left p-3 ' v-for="comments in reviewArray">
                        <h5>
                            {{comments['emailaddr']}} &nbsp

                            <span v-for="i in parseInt(comments['reviewrating'])" style='font-size:14px'>
                                <i class='fa fa-star fa-lg' style='color:yellow'></i>
                            </span>

                        </h5>

                        <div class='mt-3'>
                            {{comments['reviewmessage']}}
                        </div>
                        <div class='text-right' style='font-size:11px;font-variant:small-caps'>
                            <span style='color:grey'>{{comments['reviewdatetime']}}</span>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <!--News & Weather & Cart -->
            <div class="col-sm-4 text-center" v-if="error != 1"> 
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <span style='font-size:14px'>
                            100% Original Itinerary <i class="fa fa-check-circle" style='color:green'></i>
                        </span>
                        <h5 class="card-title">Tour Title: {{tourtitle}}</h5>
                        <p class="card-text text-left">
                            Category: {{tourcategory}} <br>
                            Price: ${{price}}
                        </p>
                        <!--Redirect to login if session does not exist -->
                        <a href="login.php" class="btn btn-warning p-2" style="font-size:14px" v-if="userid ==0">ADD TO CART <i class="fa fa-cart-plus"></i></a>
                        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-warning p-2" style="font-size:14px" v-on:click="insertCart()" v-else>ADD TO CART <i class="fa fa-cart-plus"></i></button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{tourtitle}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <i class='fa fa-shopping-cart' style='font-size:100px;float:left'></i> <br>
                                        {{cartmessage}}

                                    </div>
                                    <div class="modal-footer">
                                        <!--TO CHANGE CHECKOUT.HTML-->
										<?php 
										$email=$_SESSION["email"];
										echo"<a type='button' class='btn btn-primary' href='checkout.php?email=$email'>Checkout</a>";
										?>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Weather -->
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Weather</h5>
                        <p class="card-text text-center">
                            <span style="text-transform:capitalize">{{weatherdesc}}</span> 
                            <br>
                            <i class='fa fa-thermometer-quarter'></i> Temperature: {{weathertemp}}<span>&#8451</span>
                            <br>
                            <i class='fa fa-tint'></i> Humidity: {{weatherhumidity}}%
                            <br>
                            <i class='fa fa-cloud'></i> Wind: {{weatherwindspeed}}m/s
                        </p>
                    </div>
                </div>
                <!-- News -->
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">News</h5>
                        <p class="card-text text-left">
                            
                            <img class="card-img-top" :src="newsimage">
                            <h5>{{newstitle}}</h5>
                            <p>{{newsdescription}}</p>                      
                            <span style='font-size:10px;font-variant:small-caps'>Article written on: {{newsdate}}</span>
                            <br>
                            <a :href="newsurl" target="_blank">Click here to read more</a>
                        </p>
                    </div>
                </div>

            </div>

            <div class='mt-5 text-center' v-else>
                <h3>OOPS No such itinerary exists! <a href="index.php">Click here</a> to go back to home</h3>
                <img src='https://media4.giphy.com/media/L95W4wv8nnb9K/giphy.gif'>
            </div>
        </div>
    </div>
	
	<?php include("includes/footer.php");?>
    <script>
        var get_display_info_URL = "http://localhost:8000/api/v1/retrieve_itinerary_details";
        var add_to_cart_URL = "http://localhost:8000/api/v1/cart/insert";
        var app = new Vue({
            el: "#app",
            data:{
                itineraryid: <?php echo $itineraryid ?>,
                userid: "<?php echo $userid ?>",
                country: '',
                timecreated:'',
                price: '',
                season: '',
                thumbnail: '',
                tourcategory: '',
                tourtitle: '',
                error: '',
                
                detailsArray: [],
                
                reviewCheck:1,
                reviewError:'',
                reviewArray: [],
                averageRating: "-",

                newsCheck: 1,
                newsError: '',
                newsdescription:'',
                newsimage: '',
                newsdate: '',
                newstitle: '',
                newssource: '',
                newsurl: '',

                weathertemp:'',
                weatherdesc: '',
                weatherhumidity:'',
                weatherwindspeed:'',  

                cartmessage:''
            },
            created: function () {
                let jsonData = JSON.stringify({
                    itineraryid: this.itineraryid,
                });
                fetch(get_display_info_URL,
                {
                    method: "POST",
                    headers: {
                                "Content-type": "application/json"
                    },
                    body: jsonData
                }).then(response => response.json())
                .then(data => {
                    result = data.data;
                    itinerary_info = result.itinerary_info.data;
                    this.country = itinerary_info.country;
                    this.timecreated = itinerary_info.datetimecreated;
                    this.price = itinerary_info.price;
                    this.thumbnail = itinerary_info.thumbnail;
                    this.tourcategory = itinerary_info.tourcategory;
                    this.tourtitle = itinerary_info.tourtitle;
                    this.season = itinerary_info.season;
                    
                    itinerarydetails_info = result.itinerarydetails_info.data.itinerarydetails;
                    for (record of itinerarydetails_info) {
                        if (record['daynumber'] == 1) {
                            this.detailsArray.push(record);
                        }
                    }
                    if(typeof(result.review_info.data) != "undefined"){
                        review_info = result.review_info.data.review;
                        reviewCount = review_info.length;
                        if(reviewCount >=5){
                            for (i=reviewCount; i>reviewCount-5;i--) {
                                this.reviewArray.push(review_info[i]);
                            }
                        }
                        else{
                            for(record of review_info){
                                this.reviewArray.push(record);
                            }
                        }
                        this.averageRating = 0
                        for(record of review_info){
                            this.averageRating += parseInt(record['reviewrating']);
                        }
                        this.averageRating = this.averageRating/reviewCount;
                        this.averageRating= this.averageRating.toFixed(2);
                    }else{
                        this.reviewCheck = 0;
                        this.reviewError = result.review_info.message;
                    }

                    news_info = result.news_info;
                    articlenumber =news_info.totalArticles
                    if(articlenumber >0){
                        article = news_info.articles[0];
                        this.newsdescription = article.description;
                        this.newsimage = article.image;
                        this.newsdate = article.publishedAt;
                        this.newstitle = article.title;
                        this.newssource = article.source.name;
                        this.newsurl = article.url;

                    }
                    else{
                        this.newsCheck = 0;
                        this.newsError = "There are no articles ";
                    }
					
					if(result.weather_info.cod != "404"){
						weather_info = result.weather_info;
						
						this.weathertemp = weather_info.main.temp;
						this.weatherdesc = weather_info.weather[0]["description"];
						this.weatherhumidity = weather_info.main.humidity;
						this.weatherwindspeed = weather_info.wind.speed;
					}

                }).catch(error => {
                            console.log("Problem in retrieving display. " + error);
                            this.error = 1;
                        })       
            }, 
            /*TO DO, ADD TO CART FUNCTION */
            methods: {
                insertCart: function() {
                    fetch(add_to_cart_URL,
                        {
                            method: "POST",
                            headers: {
                                "Content-type": "application/json"
                            },
                            body: JSON.stringify(
                                {
                                    "emailaddr": this.userid,
                                    "itineraryid": this.itineraryid,
                                    "price": this.price,
                                    "tourtitle": this.tourtitle
                                })
                        })
                        .then(response => response.json())
                        .then(data => {
                            result = data;
                            // 3 cases
                            switch (data.code) {
                                case 201:
                                    // 201
                                    this.cartmessage = this.tourtitle +
                                        ` was successfully added to cart`;
                                    break;

                                case 400:
                                    // 400 
                                    this.cartmessage = "Error: " + data.message;
                                        ;
                                    break;
                                case 500:
                                    // 500 
                                    this.cartmessage =
                                        `Cart error:
                                        Cart Result:
                                        Error ${result.code}

                                        Error handling:
                                        ${data.message}`;
                                    break;
                                default:
                                    orderMessage = `Unexpected error: ${data.code}`;
                                    console.log(`Unknown error code : ${data.code}`);
                                    break;

                            } // switch
                        })
                        .catch(error => {
                            console.log("Problem in adding to cart. " + error);
                        })
                }
            }
        });

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>