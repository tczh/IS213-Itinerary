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
    <style>
        .highlight {
            background: url(https://www.andyhooke.co.uk/wp-content/uploads/2018/02/yellow-brushstroke.png);
            background-repeat: no-repeat;
            background-size: 100% 100%;
            padding: 1px 0;
        }

        .highlight2 {
            background: url("./images/brush-stroke-banner-3.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 90% auto;
            padding: 8px 0;
            color: white;
        }

        .box1{
            height:200px;
            background-color:white; 
            margin-top: 15px;
            margin-left:15px;
            margin-right:15px;
            margin-bottom:25px;
            border-radius:5px;
            background-color: #EBA39E;
            padding: 10px
        }
        .box1 h3{
            font-family: 'Didact Gothic', sans-serif;
            font-weight:normal;
            text-align:center;
            color:#fff;
        }
        .shadow1{
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            position:relative;
        }

    </style>
</head>

<body>
    <?php
        if (!isset($_GET['itineraryid'])) {

            // redirect to login page
            header("Location: index.php");

            // stop all further execution 
            // (if there are statements below)
            exit;
        }
    ?>
    <?php
        session_start();
        $_SESSION['email'] = '1'
    ?>

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
                <h3 class='highlight2'>Activities</h3>
                <br>
                <div v-for="day in daycount" :key="day">
                    <h4 class='text-left' style="font-variant:small-cap"><span class='highlight'>&nbsp&nbsp&nbsp Day {{day}} &nbsp&nbsp</span></h4>
                    <div v-for="activities in detailsArray">
                        <div class ="box1 shadow1" v-if="day == activities['daynumber']">
                            <h3>{{activities["activity"]}}</h3>
                            <i class="fa fa-map-marker" style='color:red'></i> {{activities['location']}} <br>
                            <i class="fa fa-clock-o" style='color:green'></i> {{activities['timestart']}} - {{activities['timeend']}} <br>
                            <br>
                            {{activities['description']}}
                            <br><br>
                        </div>
                    </div>
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
            <!--News & Weather-->
            <div class="col-sm-4 text-center" v-if="error != 1"> 
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

    <script>
        var get_display_info_URL = "http://localhost:5200/itinerary_display";
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
                
                daycount: 0,
                daylist: [],
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
                weatherwindspeed:''  
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
                    console.log(data);
                    result = data.data;
                    console.log(result);
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
                        this.daycount = record["daynumber"]
                        this.detailsArray.push(record);
                        console.log(record);
                    }
                    if(typeof(result.review_info.data) != "undefined"){
                        review_info = result.review_info.data.review;
                        reviewCount = review_info.length;
                        console.log("test")
                        if(reviewCount >=5){
                            for (i=reviewCount; i>reviewCount-5;i--) {
                                this.reviewArray.push(review_info[i]);
                            }
                        }
                        else{
                            for(record of review_info){
                                this.reviewArray.push(record);
                                console.log(record);
                            }
                        }
                        this.averageRating = 0
                        for(record of review_info){
                            this.averageRating += parseInt(record['reviewrating']);
                            console.log(this.averageRating);
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

                    weather_info = result.weather_info;
                    this.weathertemp = weather_info.main.temp;
                    this.weatherdesc = weather_info.weather[0]["description"];
                    this.weatherhumidity = weather_info.main.humidity;
                    this.weatherwindspeed = weather_info.wind.speed;

                }).catch(error => {
                            console.log("Problem in retrieving display. " + error);
                            this.error = 1;
                        })       
            }, 
            
        });

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>