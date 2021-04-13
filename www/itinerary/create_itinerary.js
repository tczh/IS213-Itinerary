window.onload=function(){
  window.sessionStorage;
  var newDayBtn = document.getElementById("newDayBtn");
  newDayBtn.addEventListener("click", incrementDay, false); 
  
  list_countries();
};

function incrementDay() {
  var newValue = parseInt(document.getElementById("newDayBtn").value, 10);
  newValue++;
  document.getElementById('newDayBtn').value = newValue;
  addNewDay(newValue);
};

function isEmpty(list) {
  for (node of list) {
      for(element of node) {
          var el = element.value;
          if ((el === "") ||  (typeof el === 'undefined')){
              return true;   
          }
      }
  }
  return false;
};

function validation( tourTitle,tourCategory,season,country,price,imageURL ) {
  var errors = [];

  var startTime = document.getElementsByClassName("startTime");
  var endTime = document.getElementsByClassName("endTime");

  var activityTitles = document.getElementsByClassName("activity");
  var locations = document.getElementsByClassName("location");

    if (tourTitle == ""||tourCategory == "" || season== null|| country== "" || price == "" || imageURL == null || isEmpty([startTime, endTime, activityTitles, locations])) {
        errors.push("Do not leave empty sections.</br>");
    } 
    var thumbnailExists = sessionStorage.getItem("thumbnailExists");

    if (thumbnailExists == 'false') {
        errors.push("Invalid image. </br>");
    }

    if ( !isEmpty([startTime,endTime])) {
      if ( checkTime(startTime, endTime)) {
        errors.push ("Start time must be before end time.</br>");
      }
    }
    
    if (errors.length>0) {
      sessionStorage.setItem("errors", errors);
      return false; 
   }

   return true;  
  
};

function checkTime(startTimeList, endTimeList) {
  for (i = 0; i < startTimeList.length; i++) {
      var startTime = startTimeList[i].value;
      var endTime = endTimeList[i].value;

      var startTimeArr = startTime.split(":");
      var endTimeArr = endTime.split(":");

      var startHour = startTimeArr[0];
      var startMinute = startTimeArr[1];
     
      var endHour = endTimeArr[0];
      var endMinute = endTimeArr[1];
     
      if (endHour < startHour) {
          return true;
      } else if ( (endHour == startHour) && (endMinute < startMinute) ) {
          return true;
      };
  }

  return false;

}

function addNewDay(day) {
  var html = `
  <div class="jumbotron d-flex align-items-center my-2">
      <div class="container-lg py-2 rounded-3" id="Day${day}" > 
                    
            <form>
              <div class="note">
                <h3 class="d-inline-block dayNum">Day ${day}</h3> <button class="btn rounded-3 pull-right" id="removeDay${day}" value="${day}" onclick="removeElement(${day})" ><i class="fa fa-close"></i></button>
              </div>

              <div class="form-content" >
                <div class="container" id="actDay${day}">
                <div class="container" style="padding:0;">
                <div class="mb-3">
                    <label for="activity" class="form-label">Activity Title</label>
                    <input type="text" class="form-control activity"  >
                </div>

                <div class="row mb-3">
                <div class="col-md-6">
                    <label for="startTime" class="form-label">Start Time</label>
                    <input type="time" class="form-control startTime" >
                </div>
                <div class="col-md-6">
                    <label for="endTime" class="form-label">End Time</label>
                    <input type="time" class="form-control endTime" >
                </div>
                </div>

                <div class="mb-3">
                  <label for="location" class="form-label">Location</label>
                  <input type="text" class="form-control location" >
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <input type="textarea" class="form-control description" >
                </div>

		</div>
                </div>
                <button type="button" class="btn btnSubmit" id="addActDay${day}" value="${day}" onclick="addNewAct(this.value)">Add a new activity</button>
                
              </div>
                
              </form>
        </div>
    </div>
  `;
  var node = document.getElementById("content");
  node.insertAdjacentHTML("beforeend", html);
};

function removeElement(day) {
  var id = `Day${day}`;
  var element = document.getElementById(id);
  element.parentNode.removeChild(element);
  fixDayNum(day);
};

function fixDayNum(day) {
  console.log("in fix day num");
  var day_removed = parseInt(day);

  var value = parseInt(document.getElementById("newDayBtn").value, 10);
  console.log(`${value} is value`);
  if (day_removed == value) {
      value = value - 1;
      document.getElementById('newDayBtn').value = value;
  } else {
      var arr_nodes = document.getElementsByClassName("dayNum");
      var index = day_removed - 1;
      var nodes = Array.prototype.slice.call(arr_nodes, index)

      for (node of nodes) {
          var regex = /\d+/g;
          var dayNum = node.innerText.match(regex);

          dayNum = dayNum[0] - 1;
          node.innerText = `Day ${dayNum}`;

          var org_dayNum = dayNum+1;

          document.getElementById(`removeDay${org_dayNum}`).id = `removeDay${dayNum}`;
          document.getElementById(`removeDay${dayNum}`).setAttribute('onclick',`removeElement(${dayNum})`);
          document.getElementById(`removeDay${dayNum}`).setAttribute('value',`${dayNum}`);
          document.getElementById(`Day${org_dayNum}`).id = `Day${dayNum}`;
          document.getElementById(`actDay${org_dayNum}`).id = `actDay${dayNum}`;
          document.getElementById(`addActDay${org_dayNum}`).id = `addActDay${dayNum}`;
          document.getElementById(`addActDay${dayNum}`).value = dayNum;
      }

      value = value - 1;
      document.getElementById('newDayBtn').value = value;
  }
};

function addNewAct(day_num) {
  var activityNumber = incrementActivity();
  var html = `
  <div class="container" id="activity${activityNumber}" style="padding:0;">
  <div class="mb-3">
      <label for="activity" class="form-label">Activity Title</label> <button class="btn rounded-3 pull-right" onclick="removeActivity(${activityNumber})"><i class="fa fa-close"></i></button>
      <input type="text" class="form-control activity" >
  </div>

  <div class="row mb-3">
  <div class="col-md-6">
      <label for="startTime" class="form-label">Start Time</label>
      <input type="time" class="form-control startTime">
  </div>
  <div class="col-md-6">
      <label for="endTime" class="form-label">End Time</label>
      <input type="time" class="form-control endTime" >
  </div>
  </div>

  <div class="mb-3">
    <label for="location" class="form-label">Location</label>
    <input type="text" class="form-control location"  >
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="textarea" class="form-control description" >
  </div>

  </div>
  `;
  var node = document.getElementById(`actDay${day_num}`);
  node.insertAdjacentHTML("beforeend", html);
}

var incrementActivity = (function(n) {
  return function() {
    n += 1;
    return n;
  }
}(1));

function removeActivity(activityNumber) {
  var element = document.getElementById(`activity${activityNumber}`);
  element.parentNode.removeChild(element);

}

async function imageExists(imageSrc) {

  return new Promise(function(resolve,reject){
    var img = new Image();
    img.src = imageSrc;
    img.onload = resolve;
    img.onerror = reject;
      })
}

//update func
async function general_data() {
  document.getElementById("error-modal-body").innerHTML = "loading...";
  document.getElementById("errorsFooter").innerHTML = `` ;
  document.getElementById("closeBtn").innerHTML =`<button type="button btn" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>`;

  console.log("--------------");
  if( document.getElementById("fileName").value != null ) {

    await imageExists(document.getElementById("fileName").value).then(function(){
    //It exists
    sessionStorage.setItem("thumbnailExists", "true");
    },function(){
    //It does not exist
    sessionStorage.setItem("thumbnailExists", "false");
    })  

  }

  var tourTitle = document.getElementById("title").value;
  var country = document.getElementById("country-select").value;
  var price = document.getElementById("price").value;
  var imageURL = document.getElementById("fileName").value;

  var isValidated = validation(tourTitle,document.querySelector('input[name="category"]:checked'),document.querySelector('input[name="season"]:checked'),country,price,imageURL);

  if ( !isValidated) {
    // not validated
	var errors = sessionStorage.getItem("errors");
    var newErrors = errors.replace(/,/g, '');
    var error_msg = "";
    for (error of newErrors) {
      error_msg += error;
    }
    document.getElementById("error-modal-body").innerHTML = error_msg;
  } else {
    var tourCategory = document.querySelector('input[name="category"]:checked').value;
    var season = document.querySelector('input[name="season"]:checked').value;
    sendItinerary(itineraryOwner,tourTitle,tourCategory,country,price,imageURL,season);
  }
}


async function sendItinerary(itineraryOwner,tourTitle,tourCategory,country,price,imageURL,season){
  let HasApproved = false;
  var date = new Date();

  var data = { 
    "Itineraryowner": itineraryOwner, 
    "tourtitle": tourTitle, 
    "tourcategory": tourCategory, 
    "country": country, 
    "price": price, 
    "thumbnail": imageURL, 
    "season": season,
    "HasApproved": HasApproved
  };
    // Change serviceURL to your own
    var serviceURL = "http://localhost:8000/api/v1/createitinerary";
    
    try {
        const response =
            await fetch(
                serviceURL, { 
                    method: 'POST',
                    headers: {'Accept': 'application/json' ,"Content-Type": "application/json"},
                    body: JSON.stringify(data) 
                }
            );
            const result = await response.json();
            console.log(result);
            getLatestId();
            
    } catch (error) {
        // Errors when calling the service; such as network error, 
        // service offline, etc
        console.log("Cannot connect!");
    } // error
}

function getLatestId() {
  var url = "http://localhost:8000/api/v1/itinerary/latest";
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myArr = JSON.parse(this.responseText);
        console.log(myArr['data']);
        details_data(myArr['data']);
    }
  };
  xmlhttp.open("GET", url, false);
  xmlhttp.setRequestHeader("Content-type", "application/json");
  xmlhttp.send();
}

function details_data(itinerary_id){
  var total_num_days = document.querySelectorAll('[id^="Day"]');

  var currentDay = 1;

  for (day of total_num_days) {
      InsertEachDay(day, currentDay,itinerary_id);
      currentDay += 1;
  };

  document.getElementById("error-modal-body").innerHTML = "Thank you for creating your itinerary! Do wait for the approval of your itinerary.";
  document.getElementById("errorsFooter").innerHTML = `<button class="btn btnSubmit" data-dismiss="modal" id="redirectBtn" onclick="location.href='index.php';">Done</button> `;
  document.getElementById("closeBtn").innerHTML ="";
  $('#errorModal').modal('show');
}

function InsertEachDay(day, currentDay,itinerary_id) {
    var activities = day.querySelectorAll(".activity");
    var startTimes = day.querySelectorAll(".startTime");
    var endTimes = day.querySelectorAll(".endTime");
    var locations = day.querySelectorAll(".location");
    var descriptions = day.querySelectorAll(".description");

    for (activityNum = 0; activityNum < activities.length; activityNum++) {
        var location = locations[activityNum].value;
        var activity = activities[activityNum].value;
        var activitynumber = activityNum + 1;
        var description = descriptions[activityNum].value;
        //change timings to strs
        var starttime = startTimes[activityNum].value;
        var endtime = endTimes[activityNum].value;

        var starttime = starttime.toString();
        var endtime = endtime.toString();

        sendItineraryDetails(itinerary_id, currentDay,location,activity,activitynumber,description,starttime,endtime );
    };
}

function sendItineraryDetails(itinerary_id, currentDay,location,activity,activitynumber,description,starttime,endtime ){
  var data = { 
    "itineraryid": itinerary_id, 
    "daynumber": currentDay, 
    "location": location, 
    "activitynumber": activitynumber, 
    "timestart": starttime, 
    "timeend": endtime, 
    "activity": activity,
    "description": description
  };
  // Creating a XHR object
  let xhr = new XMLHttpRequest();
  var detailsid = 0;
  let url = "http://localhost:8000/api/v1/createitinerary/details";
  // open a connection
  xhr.open("POST", url, false);
  xhr.setRequestHeader("Content-Type", "application/json");
  // Set the request header i.e. which type of content you are sending
  //xhr.setRequestHeader("Content-Type", "application/json");
  // Create a state change callback
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          // Print received data from server
          result.innerHTML = this.responseText;
      }
  };
  // Converting JSON data to string
  xhr.send(JSON.stringify(data));
}

function list_countries() {
  //console.log("in country_dropdown");
  const countries = [
    "Afghanistan",
    "Albania",
    "Algeria",
    "American Samoa",
    "Andorra",
    "Angola",
    "Anguilla",
    "Antarctica",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Aruba",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bermuda",
    "Bhutan",
    "Bolivia",
    "Bonaire",
    "Bosnia and Herzegovina",
    "Botswana",
    "Bouvet Island",
    "Brazil",
    "British Indian Ocean Territory",
    "Brunei Darussalam",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cabo Verde",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cayman Islands",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Christmas Island",
    "Cocos Islands",
    "Colombia",
    "Comoros",
    "Congo",
    "Congo",
    "Cook Islands",
    "Costa Rica",
    "Croatia",
    "Cuba",
    "Curaçao",
    "Cyprus",
    "Czechia",
    "Côte d'Ivoire",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Eswatini",
    "Ethiopia",
    "Falkland Islands",
    "Faroe Islands",
    "Fiji",
    "Finland",
    "France",
    "French Guiana",
    "French Polynesia",
    "French Southern Territories",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Gibraltar",
    "Greece",
    "Greenland",
    "Grenada",
    "Guadeloupe",
    "Guam",
    "Guatemala",
    "Guernsey",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Heard Island and McDonald Islands",
    "Holy See",
    "Honduras",
    "Hong Kong",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Isle of Man",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jersey",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Kuwait",
    "Kyrgyzstan",
    "Lao People's Democratic Republic",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macao",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Martinique",
    "Mauritania",
    "Mauritius",
    "Mayotte",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Montserrat",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Caledonia",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Niue",
    "Norfolk Island",
    "Northern Mariana Islands",
    "Norway",
    "North Korea",
    "Oman",
    "Pakistan",
    "Palau",
    "Palestine, State of",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Pitcairn",
    "Poland",
    "Portugal",
    "Puerto Rico",
    "Qatar",
    "Republic of North Macedonia",
    "Romania",
    "Russian Federation",
    "Rwanda",
    "Réunion",
    "Saint Barthélemy",
    "Saint Helena, Ascension and Tristan da Cunha",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Martin",
    "Saint Pierre and Miquelon",
    "Saint Vincent and the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Sint Maarten",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Georgia and the South Sandwich Islands",
    "South Korea",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Svalbard and Jan Mayen",
    "Sweden",
    "Switzerland",
    "Syrian Arab Republic",
    "Taiwan",
    "Tajikistan",
    "Tanzania, United Republic of",
    "Thailand",
    "Timor-Leste",
    "Togo",
    "Tokelau",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Turks and Caicos Islands",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom of Great Britain and Northern Ireland",
    "United States Minor Outlying Islands",
    "United States of America",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Venezuela",
    "Vietnam",
    "Virgin Islands",
    "Wallis and Futuna",
    "Western Sahara",
    "Yemen",
    "Zambia",
    "Zimbabwe",
  ];
  str = "";
  for(var i=0; i<countries.length;i++){
    str +=`<option value="${countries[i]}">${countries[i]}</option>`;
  };
  var el = document.getElementById("country-select");
  el.innerHTML += str;

}
