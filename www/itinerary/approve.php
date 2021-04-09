<?php
	session_start();
	if (isset($_SESSION["role"]))
	{
		if ($_SESSION["role"] != "admin")
		{
			header("Location: index.php");
		}
		
	}; 
?>
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

	<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">
	<style>
		<?php include("includes/css.txt");?>
	</style>
</head>
<?php include("includes/header.php");?>
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
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#approveModal" v-on:click="approveItinerary(itinerary['itineraryid'])">&nbsp Approve &nbsp</button>
                        <a class="btn btn-primary btn-sm" :href="'verifieditinerarypage.php?itineraryid='+itinerary['itineraryid']" role="button">&nbsp View &nbsp</a>
                    </div>
                </div>
            </div>
            <hr>
        </div>
		<div class="modal fade" id="approveModal" data-backdrop="static" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalHeader">Approve Message</h5>
					</div>
					<div class="modal-body">
						<p id="modalBody">{{message}}</p>
					</div>
					<div class="modal-footer">
						<a class="btn btn-primary" role="button" href="approve.php" id="modalBtn">Close</a>
					</div>
				</div>
			</div>
		</div>
    </div>
	<?php include("includes/footer.php");?>

    <script>
        get_all_itinerary_URL = "http://localhost:8000/api/v1/itinerary";
		approve_itinerary_URL = "http://localhost:8000/api/v1/itinerary_approval"
        var app = new Vue
        ({
            el: "#app",
            data:{
                createdarray: [],
				message: ''
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
            },
			methods: {
				approveItinerary: function(itineraryid) {
					fetch(approve_itinerary_URL,
                        {
                            method: "POST",
                            headers: {
                                "Content-type": "application/json"
                            },
                            body: JSON.stringify(
                                {
                                    "itineraryid": itineraryid,
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
                                    this.message = `ItineraryID: `+itineraryid +
                                        ` has been successfully approved!`;
                                    break;

                                case 400:
                                    // 400 
                                    this.message = "Error: " + data.message;
                                        ;
                                    break;
                                case 500:
                                    // 500 
                                    this.message =
                                        `Approve error:
                                        Approve Result:
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
                            console.log("Problem in approving. " + error);
                        })

				}

			}

        })

    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>