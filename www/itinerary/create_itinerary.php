<?php
	session_start();
    if(!isset($_SESSION["email"]))
    {
        header("Location: index.php");
    } 
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom JavaScript -->
	<script type="text/javascript">
    var itineraryOwner='<?php echo $_SESSION["email"];?>';
    </script>
    <script src="create_itinerary.js" ></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="css/create_itinerary.css" rel="stylesheet">

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   

	<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i" rel="stylesheet">

    <title></title>
	<style>
		<?php include("includes/css.txt");?>
	</style>
  </head>
  <body>
 	<?php include("includes/header.php");?>
    <div class="jumbotron d-flex align-items-center my-2">
        <div class="container-lg py-2 rounded-3" > 
        <!-- <h2>
            Overview of Itinerary
        </h2> -->

        <form>

            <div class="note">
                <h3 class="d-inline-block"> Overview of Itinerary</h3>
            </div>

            <div class="form-content">

            <div class="mb-3">
                <label for="description" class="form-label">Tour Title</label>
                <input type="textarea" class="form-control" id="title">
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Country</label>
              <select class="form-control" id="country-select">
                <option disabled selected value> -- select an option -- </option>
              </select>
          </div>

            <div class="mb-3">
              <label for="description" class="form-label">Season </label> </br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="season" id="spring" value="Spring">
                <label class="form-check-label" for="spring">Spring</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="season" id="summer" value="Summer">
                <label class="form-check-label" for="summer">Summer</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="season" id="fall" value="Fall" >
                <label class="form-check-label" for="fall">Fall</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="season" id="winter" value="Winter" >
                <label class="form-check-label" for="winter">Winter</label>
              </div>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Category of trip  </label> </br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="business" value="Business">
                <label class="form-check-label" for="business">Business</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="solo" value="Solo">
                <label class="form-check-label" for="solo">Solo</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="friends" value="Friends" >
                <label class="form-check-label" for="friends">With Friends</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="family" value="Family" >
                <label class="form-check-label" for="family">Family</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="group" value="Group" >
                <label class="form-check-label" for="group">With Group</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="luxury" value="Luxury" >
                <label class="form-check-label" for="luxury">Luxury</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="adventure" value="Adventure" >
                <label class="form-check-label" for="adventure">Adventure</label>
              </div>
            </div>


            <div class="mb-3">
                <label for="image" class="form-label">Enter a Image URL</label>
                <input name="image" class="form-control" type="url" id="fileName"/>
                <!-- <input name="image" class="form-control" type="url" id="fileName" onchange="validateFileType()"/> -->
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Price</label>
                <input type="number" min="0" class="form-control" id="price">
            </div>
            <!-- <div class="mb-3">
              <button type="button" class="btnSubmit" >Upload</button>
            </div> -->

        </div>

        </form>
        </div>
    </div>

    <!-- End of Overview -->

    <!-- Main stuff -->
    <div id="content">
    <div class="jumbotron d-flex align-items-center my-2">
      <div class="container-lg py-2 rounded-3" id="Day1" > 
                    
            <form>
              <div class="note">
                <h3 class="d-inline-block dayNum">Day 1</h3> 
                <!-- <button class="btn rounded-3 pull-right" ><i class="fa fa-close"></i></button> -->
              </div>

              <div class="form-content" >
                <!-- Start of container for activities -->
                <div class="container" id="actDay1">
                <!-- start of container of first item in day 1 -->
                <div class="container">
                <div class="mb-3">
                    <label for="activity" class="form-label">Activity Title</label>
                    <input type="text" class="form-control activity" id="activity" >
                </div>

                <div class="row mb-3">
                <div class="col-md-6">
                    <label for="startTime" class="form-label">Start Time</label>
                    <input type="time" class="form-control startTime" id="startTime">
                </div>
                <div class="col-md-6">
                    <label for="endTime" class="form-label">End Time</label>
                    <input type="time" class="form-control endTime" id="endTime">
                </div>
                </div>

                <div class="mb-3">
                  <label for="location" class="form-label">Location</label>
                  <input type="text" class="form-control location" id="location" >
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <input type="textarea" class="form-control description" id="description">
                </div>

                </div>
                <!-- end of container of first item in day 1 -->
                </div>
                <!-- End of container for activities -->
              
                <button type="button" class="btn btnSubmit" id="addActDay1" value="1" onclick="addNewAct(this.value)">Add a new activity</button>
                
              </div>
                
              </form>
        </div>
    </div>
    </div>

    <div class="jumbotron d-flex align-items-center my-2">
      <div class="container-lg py-2 rounded-3" > 
        <button type="button" class="btn btnSubmit" id="newDayBtn" value="1">Add a new day</button>
      </div>
    </div>

    
    <!-- Price input -->
    <div class="container-fluid p-2" id="submit" style="position: sticky;bottom: 0; margin-left: 0px; background: -webkit-linear-gradient(left, #0072ff, #8811c5); overflow: hidden;">
          <form>
            <button type="button" class="btn btnSubmit pull-right" onclick="general_data()" data-toggle="modal" data-target="#errorModal">Submit</button> 
          </form>
    </div>

	<!--form validation error modal-->
	<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Itinerary Creation</h5>
              <span id="closeBtn">
              <button type="button btn" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </span>
            </button>
          </div>
          <div class="modal-body" id="error-modal-body">
            loading...
          </div>
          <div class="modal-footer" id="errorsFooter">
           <!-- <button class="btn btnSubmit" data-dismiss="modal" id="redirectBtn">Done</button> -->
          </div>
        </div>
      </div>
    </div>

	<?php include("includes/footer.php");?>
  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>