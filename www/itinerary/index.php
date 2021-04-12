<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="index.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="login.js"></script>
    <script src="signup.js"></script>

    <style>
        * {
               margin: 0;
        }

        .hero{
            background-image: url("images/scenery.jpg");
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            height: 100%;
            margin-bottom: 12px;
        }
        #searchBar{
            padding:20px;
            border-radius: 20px;
            margin: 150px;
            min-width: 320px;
        }

        #searchText{
            font-size: 30px;
        }

        #categories {
            margin-top: 10px;
            text-align: center;
        }

        .categories {
            margin-left:50px;
            margin-right:50px;
            margin-bottom: 10px;
        }

        #cards {
            margin-left: 10%;
            margin-right: 10%;
        }

        #nextback {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        #nextbtn, #backbtn {
            margin-left: 10px;
            margin-right: 10px;
        }

		<?php include("includes/css.txt");?>

    </style>
    
    
</head>
<body onload="load()">
<?php include("includes/header.php");?>
    
    <!-- Navbar collapse if width is sm-->
    <header class="hero">
    <!--Itinerary search bar-->
    <div class="container-fluid text-center" id="searchBarImage">
        <div class = "row justify-content-center">
            <div class= "col-4 bg-light" id="searchBar">       

                <label id="searchText" class="">Find your dream itinerary!</label>
                <div id="country"></div>
                <input id="locationInput" class="form-control mb-3" type="search" placeholder="Enter Your Dreamland (Country)" aria-label="Search">

                <div class="form-group">
                    <select class="form-control" id="pricerange">
                    <option value='0'>Price Range</option>
                    <option value='1'>Less than $10</option>
                    <option value='2'>$10 - $19.99</option>
                    <option value='3'>$20 - $29.99</option>
                    <option value='4'>$30 - $39.99</option>
                    <option value='5'>$40 - $49.99</option>
                    <option value='6'>$50 or more</option>
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control" id="season">
                        <option>Season</option>
                        <option>Spring</option>
                        <option>Summer</option>
                        <option>Fall</option>
                        <option>Winter</option>
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control" id="category">
                    <option>Category</option>
                    <option>Business</option>
                    <option>Solo</option>
                    <option>With Friends</option>
                    <option>Family</option>
                    <option>Group</option>
                    <option>Luxury</option>
                    <option>Adventure</option>
                    </select>
                </div>

                <button class="btn btn-warning" type="submit" onclick=filter()>Search</button>
            </div>
        </div>
    </div>
    </header>
    
    <div id="cards">
    <?php
        $url = "http://localhost:8000/api/v1/itinerary/retrieveAll";
        $itineraries = json_decode(file_get_contents($url))->data->itinerary;

        foreach ($itineraries as $itinerary) {
            $itineraryid = $itinerary->itineraryid;
            $itineraryowner = $itinerary->Itineraryowner;
            $tourtitle = $itinerary->tourtitle;
            $tourcategory = $itinerary->tourcategory;
            $country = $itinerary->country;
            $price = $itinerary->price;
            $thumbnail = $itinerary->thumbnail;
            $season = $itinerary->season;

            $itineraryArray[] = [
                "itineraryid" => $itineraryid,
                "itineraryowner" => $itineraryowner,
                "tourtitle" => $tourtitle,
                "tourcategory" => $tourcategory,
                "country" => $country,
                "price" => $price,
                "thumbnail" => $thumbnail,
                "season" => $season
            ];
        }

        $url = "http://localhost:8000/api/v1/review";
        $allreviews = json_decode(file_get_contents($url))->data->itinerary;

        $allreviewsitineraryid = [];
        foreach ($allreviews as $review) {
            $emailaddr = $review->emailaddr;
            $itineraryid = $review->itineraryid;
            $reviewdatetime = $review->reviewdatetime;
            $reviewid = $review->reviewid;
            $reviewmessage = $review->reviewmessage;
            $reviewrating = $review->reviewrating;

            
            $allreviewsitineraryid[] = $itineraryid;
        }

        $rateArray = [];

        $x=0;
        foreach ($itineraryArray as $itinerary) {
            
            if (in_array($itinerary['itineraryid'], $allreviewsitineraryid)) {
                // var_dump($allreviewsitineraryid);
                $counts = array_count_values($allreviewsitineraryid);
                $count = $counts[$itinerary['itineraryid']];
                // $count = count($allreviewsitineraryid);
                $rate = 0;

                for ($i=$x; $i<$x+$count;$i++) {
                    $rate += $allreviews[$i]->reviewrating;
                    // var_dump($rate);
                }
                // var_dump($rate);
                // var_dump($count);

                $rate = $rate/$count;
                $rateArray[] = round($rate, 2);
                $x += $count;
                // var_dump($x);
                
            }
            else {
                $rateArray[] = 'NIL';
            }
        }
    ?>
    </div>

    <div class='d-none' id='jsitin'></div>
    <div id="nextback">
        <button class="btn btn-warning" id="backbtn" disabled onclick="back()">Back</button>
        <button class="btn btn-warning" id="nextbtn" onclick="next()">Next</button>
    </div>

    <?php include("includes/footer.php");?>

    <div id='counter' class='d-none'>0</div>

    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsd6B8t6d8EIDIhtISazAvVufIy07_-U&libraries=places&callback=load"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    var rateArray = <?php echo json_encode($rateArray); ?>;

    jsItinerary = []
    count = 0;
    for (itinerary of jsItineraryWithoutRate) {
        jsItinerary.push(itinerary)
        jsItinerary[count]['rate'] = rateArray[count];
        count += 1;
    }

    function load() {
        var input = document.getElementById("locationInput");
        filter();
    }

    function filter() {
        jsItinerary = <?php echo json_encode($itineraryArray); ?>;

        var country = document.getElementById('locationInput').value;
        var price = document.getElementById('pricerange').value;
        var season = document.getElementById('season').value;
        var category = document.getElementById('category').value;

        tempArray = rateArray.slice();
   
        var str = '<div class="card-columns">';

        arrayItinerary = []

        count = 0
        for (i=0;i<jsItinerary.length;i++) {
            if (country != '' && !jsItinerary[i]['country'].toLowerCase().includes(country.toLowerCase())) {
                tempArray.splice(i,1);
                continue;
            }

            if (season != 'Season' && season.toLowerCase() != jsItinerary[i]['season'].toLowerCase()) {
                tempArray.splice(i,1);
                continue;
            }

            if (category != 'Category' && category.toLowerCase() != jsItinerary[i]['tourcategory'].toLowerCase().split(' ')[0]) {
                tempArray.splice(i,1);
                continue;
            }

            var priceArray = [[0,9.99], [10, 19.99], [20,29.99], [30,39.99], [40,49.99], [50, 9999999999]];
            if (price != 0 && ((parseFloat(jsItinerary[i]['price']) < priceArray[(price-1)][0]) || (parseFloat(jsItinerary[i]['price']) > priceArray[(price-1)][1]))) {
                tempArray.splice(i,1);
                continue;
            }

            arrayItinerary.push(jsItinerary[i]);
        }

        jsItinerary = arrayItinerary;
        document.getElementById("jsitin").innerHTML = jsItinerary;
        
        for(i=0;i<jsItinerary.length;i++){
            str += '<div class="card">';
            str += '<img class="card-img-top" src="' + jsItinerary[i]['thumbnail'] + '" alt="' + jsItinerary[i]['tourtitle'] + '">';
            str += '<div class="card-body">';
            str += '<h5 class="card-title">' + jsItinerary[i]['tourtitle'] + '</h5>';
            str += `<p class="card-text">Rating: <span id='rating${i}'> </span> <i class='fa fa-star' style='color:orange'></i></p>`;
            str += '<p class="card-text">Country: ' + jsItinerary[i]['country'] + '</p>';
            str += '<p class="card-text">Price: $' + jsItinerary[i]['price'] + '</p>';
            str += '<p class="card-text">Category: ' + jsItinerary[i]['tourcategory'] + '</p>';
            str += '<p class="card-text">Season: ' + jsItinerary[i]['season'] + '</p>';
            str += '<a href="itinerarypage.php?itineraryid=' + jsItinerary[i]["itineraryid"] + '" class="btn btn-warning">View More</a>';
            str += '</div></div>';
            count++
            if(count==3){
                break
            }
        }


        str += '</div>';

        document.getElementById("cards").innerHTML = str;

        counts = 0
        for(i=0;i<jsItinerary.length;i++){
            document.getElementById(`rating${i}`).innerHTML = tempArray[i];
            counts++
            if(counts ==3){
                break;
            }
        }
        document.getElementById('counter').innerText = 0
        $('#backbtn').attr('disabled', true);

        if (jsItinerary.length <= 3) {
            $('#nextbtn').attr('disabled', true);
        }
        else{
            $('#nextbtn').attr('disabled', false);
        }
    }

    function next() {
  
        if (document.getElementById('counter').innerText < jsItinerary.length) {
            
            var country = document.getElementById('locationInput').value;
            var price = document.getElementById('pricerange').value;
            var season = document.getElementById('season').value;
            var category = document.getElementById('category').value;
            document.getElementById('counter').innerText = parseInt(document.getElementById('counter').innerText) +3
            var str = '<div class="card-columns">';

            count = parseInt(document.getElementById('counter').innerText);
            counts = 0;
            for (i=count;i<jsItinerary.length;i++) {
                if (country != '' && !jsItinerary[i]['country'].toLowerCase().includes(country.toLowerCase())) {
                    continue;
                }

                if (season != 'Season' && season.toLowerCase() != jsItinerary[i]['season'].toLowerCase()) {
                    continue;
                }

                if (category != 'Category' && category.toLowerCase() != jsItinerary[i]['tourcategory'].toLowerCase().split(' ')[0]) {
                    continue;
                }

                var priceArray = [[0,9.99], [10, 19.99], [20,29.99], [30,39.99], [40,49.99], [50, 9999999999]];

                if (price != 0 && ((parseFloat(jsItinerary[i]['price']) < priceArray[(price-1)][0]) || (parseFloat(jsItinerary[i]['price']) > priceArray[(price-1)][1]))) {
                    continue;
                }
                
                str += '<div class="card">';
                str += '<img class="card-img-top" src="' + jsItinerary[i]['thumbnail'] + '" alt="' + jsItinerary[i]['tourtitle'] + '">';
                str += '<div class="card-body">';
                str += '<h5 class="card-title">' + jsItinerary[i]['tourtitle'] + '</h5>';
                str += `<p class="card-text">Rating: <span id='rating${i}'> </span> <i class='fa fa-star' style='color:orange'></i></p>`;
                str += '<p class="card-text">Country: ' + jsItinerary[i]['country'] + '</p>';
                str += '<p class="card-text">Price: $' + jsItinerary[i]['price'] + '</p>';
                str += '<p class="card-text">Category: ' + jsItinerary[i]['tourcategory'] + '</p>';
                str += '<p class="card-text">Season: ' + jsItinerary[i]['season'] + '</p>';
                str += '<a href="itinerarypage.php?itineraryid=' + jsItinerary[i]["itineraryid"] + '" class="btn btn-warning">View More</a>';
                str += '</div></div>';
                counts++
                if(counts== 3){
                    break;
                }

            }
            str += '</div>';

            document.getElementById("cards").innerHTML = str;
        }
        check=parseInt(document.getElementById('counter').innerText);
        counts = 0;

        for(i=check;i<jsItinerary.length;i++){
            document.getElementById(`rating${i}`).innerHTML = tempArray[i];
            counts++;
            if(counts==3){
                break;
            }
        }

        if (check >= (jsItinerary.length)-3) {
            $('#nextbtn').attr('disabled', true);
        }
        if (check != 0) {
            $('#backbtn').attr('disabled', false);
        }
    
        
    }

    function back() {
        if (document.getElementById('counter').innerText > 0) {
            var country = document.getElementById('locationInput').value;
            var price = document.getElementById('pricerange').value;
            var season = document.getElementById('season').value;
            var category = document.getElementById('category').value;
            document.getElementById('counter').innerText = parseInt(document.getElementById('counter').innerText) -3
            var str = '<div class="card-columns">';

            count = parseInt(document.getElementById('counter').innerText);
            counter = 0
            for (i=count;i<jsItinerary.length;i++) {
                if (country != '' && !jsItinerary[i]['country'].toLowerCase().includes(country.toLowerCase())) {
                    continue;
                }

                if (season != 'Season' && season.toLowerCase() != jsItinerary[i]['season'].toLowerCase()) {
                    continue;
                }

                if (category != 'Category' && category.toLowerCase() != jsItinerary[i]['tourcategory'].toLowerCase().split(' ')[0]) {
                    continue;
                }

                var priceArray = [[0,9.99], [10, 19.99], [20,29.99], [30,39.99], [40,49.99], [50, 9999999999]];

                if (price != 0 && ((parseFloat(jsItinerary[i]['price']) < priceArray[(price-1)][0]) || (parseFloat(jsItinerary[i]['price']) > priceArray[(price-1)][1]))) {
                    continue;
                }
                
                str += '<div class="card">';
                str += '<img class="card-img-top" src="' + jsItinerary[i]['thumbnail'] + '" alt="' + jsItinerary[i]['tourtitle'] + '">';
                str += '<div class="card-body">';
                str += '<h5 class="card-title">' + jsItinerary[i]['tourtitle'] + '</h5>';
                str += `<p class="card-text">Rating: <span id='rating${i}'> </span> <i class='fa fa-star' style='color:orange'></i></p>`;
                str += '<p class="card-text">Country: ' + jsItinerary[i]['country'] + '</p>';
                str += '<p class="card-text">Price: $' + jsItinerary[i]['price'] + '</p>';
                str += '<p class="card-text">Category: ' + jsItinerary[i]['tourcategory'] + '</p>';
                str += '<p class="card-text">Season: ' + jsItinerary[i]['season'] + '</p>';
                str += '<a href="itinerarypage.php?itineraryid=' + jsItinerary[i]["itineraryid"] + '" class="btn btn-warning">View More</a>';
                str += '</div></div>';
                counter++
                if(counter==3){
                    break
                }
            }
            str += '</div>';

            document.getElementById("cards").innerHTML = str;
        }

        check=parseInt(document.getElementById('counter').innerText);
        counts = 0
        for(i=check;i<jsItinerary.length;i++){
            document.getElementById(`rating${i}`).innerHTML = tempArray[i];
            counts++;
            if(counts==3){
                break;
            }
        }

        if (check == 0) {
            $('#backbtn').attr('disabled', true);
        }
        if (check <= jsItinerary.length-3) {
            $('#nextbtn').attr('disabled', false);
        }
    }

</script>
</body>
</html>