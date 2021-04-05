<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
</head>
<body>
    <!--Check admin session-->

    <div class = "container" id="app">
        <div class="container-fluid text-center bg-dark rounded p-2">
            <h2 style="color:white">Itineraries For Approval</h1>
        </div>
        <br>
        <div v-for="itinerary in createdarray" class="text-left container">
            <div class="row">
                <div class="col-sm-4 text-center align-middle">
                    <img :src="itinerary['thumbnail']" style="height:200px; width:100%;">
                </div>
                <div class="col-sm-8 text-left">
                    <br>Title: {{itinerary['tourtitle']}}
                    <br>Category: {{itinerary['tourcategory']}}
                    <br>Season: {{itinerary['season']}}
                    <br>Price: ${{itinerary['price']}}
                    <br>Time of Creation: {{itinerary['datetimecreated']}}
                    <br><br>
                    <div class='text-right'>
                        <button type="button" class="btn btn-warning btn-sm">&nbsp Approve &nbsp</button>
                        <a class="btn btn-primary btn-sm" :href="'verifieditinerarypage.php?itineraryid='+itinerary['itineraryid']" role="button">&nbsp View &nbsp</a>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <script>
        get_all_itinerary_URL = "http://localhost:5010/itinerary";
        var app = new Vue
        ({
            el: "#app",
            data:{
                createdarray: [],
            },
            created: function () {
                fetch(get_all_itinerary_URL)
                .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        result = data.data.itinerary;
                        console.log(result);
                        for (record of result) {
                            if (record['hasapproved'] == false){
                                this.createdarray.push(record);
                            }
                        }
                    })
            }
        })

    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>