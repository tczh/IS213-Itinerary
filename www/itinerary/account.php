<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Didact+Gothic' rel='stylesheet' type='text/css'>

    <style>
        div.stars{
            display:inline-block;
            top:50%;
            left:50%;
        }
        input.star{
            display:none;
        }
        label.star{
            float:right;
            padding:0px 10px;
            color: black;

        }
        input.star:checked ~label.star:before{
            content:"\f005";
            color: yellow;
            border:black 1px;
    
        }
        input .star-5:checked ~ label.star:before {
            color: "#1abc9c";
            text-shadow: 0 0 15px #1abc9c;
        }
        input .star-1:checked ~ label.star:before{
            color: "yellow";
            border:black 1px;
        }

        label.star:before{
            content:'\f006';
            font-family: FontAwesome;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        // to change
        $_SESSION['email'] = 'yuhao.neo.2019@sis.smu.edu.sg';
    ?>
    <div class = "container" id="app">
        <div class = "row">
            <?php
            //TO CHANGE
            if(isset($_SESSION['email'])) {
                $userid = $_SESSION['email'];
            } else {
                 // redirect to login page
                header("Location: index.php");

                // stop all further execution 
                // (if there are statements below)
                exit;;
                }

            ?>
            <div class="col-sm-4 text-center">
                <!--Tabs -->
                <h5>My Itineraries</h5>
                {{userid}}
        
                <hr>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Purchased Itineraries </a>
                    <a class="nav-link" id="v-pills-create-tab" data-toggle="pill" href="#v-pills-create" role="tab" aria-controls="v-pills-create" aria-selected="false">Created Itineraries</a>   
                    
                </div>
            </div>
            <div class="col-sm-8 text-center">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="container-fluid text-center bg-dark rounded p-2">
                            <h2 style="color:white">Purchased Itineraries</h1>
                        </div>
                        <br>
                        <div v-for="(itinerary,count) in purchasearray" class="text-left container">
                            <div class="row">
                                <div class="col-sm-5 text-center align-middle">
                                    <img :src="itinerary['thumbnail']" style="height:200px; width:100%;">
                                </div>
                                <div class="col-sm-7 text-left">
                                    <br>Title: {{itinerary['tourtitle']}}
                                    <br>Category: {{itinerary['tourcategory']}}
                                    <br>Season: {{itinerary['season']}}
                                    <br>Price: ${{itinerary['price']}}
                                    <br>Time of Creation: {{itinerary['datetimecreated']}}
                                    <br><br>
                                    <div class='text-right'>
                                        <!--TO DO -->
                                        <button type="button" class="btn btn-warning btn-sm" :data-target="'#reviewModal'+count" data-toggle="modal">&nbsp Leave Review &nbsp</button>
                                        <a class="btn btn-primary btn-sm" :href="'verifieditinerarypage.php?itineraryid='+itinerary['itineraryid']" role="button">&nbsp View &nbsp</a>
                                        <div class="modal fade" :id="'reviewModal'+count" tabindex="-1" role="dialog" :aria-labelledby="'reviewModal'+count+'Label'" aria-hidden="true">
                                            <div class="modal-dialog text-center" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{itinerary["tourtitle"]}} Review</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="reviewmessage=''">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                        
                                                            <textarea name="review" :id="'msg'+count" rows="4" cols="60"></textarea>
                                
                                                            <div :class="'stars stars'+count">
                                                                <input type="radio" :name="'star'+count" :id ="'star'+count+'-5'" class="star star-5" value= "5">
                                                                <label class="star star-5" :for="'star'+count+'-5'"></label>
                                                                <input type="radio" :name="'star'+count" :id ="'star'+count+'-4'" class="star star-4" value= "4">
                                                                <label class="star star-4" :for ="'star'+count+'-4'" ></label>
                                                                <input type="radio" :name="'star'+count" :id ="'star'+count+'-3'" class="star star-3" value= "3">
                                                                <label class="star star-3" :for ="'star'+count+'-3'"></label>
                                                                <input type="radio" :name="'star'+count" :id ="'star'+count+'-2'" class="star star-2" value= "2">
                                                                <label class="star star-2" :for ="'star'+count+'-2'"></label>
                                                                <input type="radio" :name="'star'+count" :id ="'star'+count+'-1'" class="star star-1" value= "1">
                                                                <label class="star star-1" :for ="'star'+count+'-1'"></label>
                                                                <br>
                                                                <br>
                                                            
                                                            </div>
                                                            <div>
                                                                <span v-if="reviewmessage=='Review was successfully added'">{{reviewmessage}} <i class='fa fa-check' style='color:green'></i></span>
                                                                <span v-else>{{reviewmessage}}</span> 
                                                            </div>
                                                            <div class="modal-footer">
                                                            <br>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="reviewmessage=''">Close</button>
                                                                <!-- TO DO -->
                                                                <button type="button" class="btn btn-primary" v-on:click="processReview(itinerary['itineraryid'],count)">Submit Review</button>
                                                                
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>       
                            </div>
                            <hr>
                        </div>
                    
                    </div>
                    <div class="tab-pane fade" id="v-pills-create" role="tabpanel" aria-labelledby="v-pills-create-tab">
                        <div class="container-fluid text-center bg-dark rounded p-2">
                            <h2 style="color:white">Created Itineraries</h1>
                        </div>
                        <br>
                        <div v-for="itinerary in createdarray" class="text-left container">
                            <div class="row">
                                <div class="col-sm-5 text-center align-middle">
                                    <img :src="itinerary['thumbnail']" style="height:200px; width:100%;">
                                </div>
                                <div class="col-sm-7 text-left">
                                    <br>Title: {{itinerary['tourtitle']}}
                                    <br>Category: {{itinerary['tourcategory']}}
                                    <br>Season: {{itinerary['season']}}
                                    <br>Price: ${{itinerary['price']}}
                                    <br>Time of Creation: {{itinerary['datetimecreated']}}
                                    <br><br>
                                    <div class='text-right'>
                                        <a class="btn btn-primary btn-sm" :href="'verifieditinerarypage.php?itineraryid='+itinerary['itineraryid']" role="button">&nbsp View &nbsp</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    <script>
        get_created_info_URL = "http://localhost:5010/itinerary/creator/";
        create_review_URL = "http://localhost:5011/review/insert";
        get_purchased_itinerary_URL = "http://localhost:5400/display_purchased_itinerary";
        var app = new Vue
        ({
            el: "#app",
            data:{
                userid: "<?php echo $userid?>",
                createdarray: [],
                purchasearray: [],
                reviewsucess: false,
                reviewmessage:""
            },
            created: function () {
                let jsonData = JSON.stringify({
                    emailaddr: this.userid,
                });
                //for created itineraries
                fetch(get_created_info_URL+this.userid)
                .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        result = data.data.itinerary;
                        console.log(result);
                        for (record of result) {
                            this.createdarray.push(record);
                        }
                    })
                
                //Add paid itineraryid into an array
                fetch(get_purchased_itinerary_URL,
                {
                    method: "POST",
                    headers: {
                                "Content-type": "application/json"
                    },
                    body: jsonData
                })
                .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        result = data.data.itinerary_info;
                        console.log(result);
                        for(itinerary of result){
                            this.purchasearray.push(itinerary);
                        }
                    })
            }, 
            methods:{
                processReview: function(itineraryid,count){
                    check0='star'+count;
                    rating = document.getElementsByName(check0);
                    check= 'msg'+count;
                    msg = document.getElementById(check).value;
                    activityRating =0;
                    for(i = 0; i< rating.length; i++){
        
                        if(rating[i].checked){
                            activityRating = rating[i].value;
                        }
                        
                    }
                    if(activityRating ==0){
                        return this.reviewmessage ="Please enter your rating!";
                    }
                    
                    console.log(activityRating);
                    console.log(msg);
                    fetch(create_review_URL,
                        {
                            method: "POST",
                            headers: {
                                "Content-type": "application/json"
                            },
                            body: JSON.stringify(
                                {
                                    "emailaddr": this.userid,
                                    "itineraryid": itineraryid, 
                                    "reviewmessage": msg, 
                                    "reviewrating": activityRating
                                })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            result = data;
                            console.log(result);
                            // 3 cases
                            switch (data.code) {
                                case 201:
                                    // 201
                                    this.reviewsucess = true;
                                    this.reviewmessage =
                                        `Review was successfully added`;
                                    break;

                                case 400:
                                    // 400 
                                    this.reviewsucess = true;
                                    this.reviewmessage = "Error: "+ data.message;
                                        ;
                                    break;
                                case 500:
                                    // 500 
                                    this.reviewmessage =
                                        `Review creation error:
                                        Review Result:
                                        Error ${result.code}

                                        Error handling:
                                        ${data.message}`;
                                    break;
                                default:
                                    reviewmessage = `Unexpected error: ${data.code}`;
                                    console.log(`Unknown error code : ${data.code}`);
                                    break;

                            } // switch
                            console.log(reviewmessage);
                            this.reviewsucess = true;
                        })
                        .catch(error => {
                            console.log("Problem in placing a review. " + error);
                        })

                }
            }
        
        })
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>