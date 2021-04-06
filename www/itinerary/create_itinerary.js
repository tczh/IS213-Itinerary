window.onload=function(){
  var newDayBtn = document.getElementById("newDayBtn");
  newDayBtn.addEventListener("click", incrementDay, false); 
  
  list_countries();
  //console.log("in onload");
};

// function validateFileType(){
//   var fileName = document.getElementById("fileName").value;
//   var idxDot = fileName.lastIndexOf(".") + 1;
//   var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
//   if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
//       //TO DO
//   }else{
//       alert("Only jpg/jpeg and png files are allowed!");
//   }   
// }

function incrementDay() {
  var newValue = parseInt(document.getElementById("newDayBtn").value, 10);
  newValue++;
  document.getElementById('newDayBtn').value = newValue;
  //console.log(newValue);

  addNewDay(newValue);
};

function addNewDay(day) {
  //console.log("add new day func ");
  var html = `
  <div class="jumbotron d-flex align-items-center my-2">
      <div class="container-lg py-2 rounded-3" id="Day${day}" > 
                    
            <form>
              <div class="note">
                <h3 class="d-inline-block dayNum">Day ${day}</h3> <button class="btn rounded-3 pull-right" id="removeDay${day}" value="${day}" onclick="removeElement(${day})" ><i class="fa fa-close"></i></button>
              </div>

              <div class="form-content" >
                <div id="actDay${day}">
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
                <button type="button" class="btn btnSubmit" id="addActDay${day}" value="${day}" onclick="addNewAct(this.value)">Add a new activity</button>
                
              </div>
                
              </form>
        </div>
    </div>
  `;
  var node = document.getElementById("content");
  node.insertAdjacentHTML("beforeend", html);

  //activatePlacesSearch();

};

function removeElement(day) {
  var id = `Day${day}`;
  //console.log("remove ele");
  //console.log(id);
  var element = document.getElementById(id);
  //console.log(element);
  element.parentNode.removeChild(element);

  fixDayNum(day);
};

function fixDayNum(day) {
  console.log("in fix day num");
  var day_removed = parseInt(day);

  var value = parseInt(document.getElementById("newDayBtn").value, 10);
  console.log(`${value} is value`);
  if (day_removed == value) {
      // console.log("-------in if day_removed == value---")
      // console.log(`${day_removed} is day removed`);
      value = value - 1;
      //console.log(`${value} is the value after fixing`)
      document.getElementById('newDayBtn').value = value;
  } else {
      var arr_nodes = document.getElementsByClassName("dayNum");
      // console.log("-------in else------");
      // console.log(`${day_removed} is day removed`);
      var index = day_removed - 1;
      //console.log(index);
      var nodes = Array.prototype.slice.call(arr_nodes, index)
      //console.log(nodes);
      //console.log("---------------");

      for (node of nodes) {
          //console.log(node);

          var regex = /\d+/g;
          var dayNum = node.innerText.match(regex);

          dayNum = dayNum[0] - 1;

          //console.log(`This is the org day num : ${org_dayNum} and this is the new day num: ${dayNum}`);

          node.innerText = `Day ${dayNum}`;

          var org_dayNum = dayNum+1;

          // console.log(`Elements before change: `);
          // console.log(document.getElementById(`removeDay${org_dayNum}`).onclick);
          // console.log(document.getElementById(`removeDay${org_dayNum}`).value);
          // console.log(document.getElementById(`removeDay${org_dayNum}`).id);
          // console.log(document.getElementById(`contentDay${org_dayNum}`));

          document.getElementById(`removeDay${org_dayNum}`).id = `removeDay${dayNum}`;
          document.getElementById(`removeDay${dayNum}`).setAttribute('onclick',`removeElement(${dayNum})`);
          document.getElementById(`removeDay${dayNum}`).setAttribute('value',`${dayNum}`);
          document.getElementById(`Day${org_dayNum}`).id = `Day${dayNum}`;
          document.getElementById(`actDay${org_dayNum}`).id = `actDay${dayNum}`;
          document.getElementById(`addActDay${org_dayNum}`).id = `addActDay${dayNum}`;
          document.getElementById(`addActDay${dayNum}`).value = dayNum;

          // console.log(`Elements after change: `);
          // console.log(document.getElementById(`removeDay${dayNum}`).onclick);
          // console.log(document.getElementById(`removeDay${dayNum}`).value);
          // console.log(document.getElementById(`removeDay${dayNum}`).id);
          // console.log(document.getElementById(`contentDay${dayNum}`).id);

          //console.log(idNodeList);

          //console.log("---------------");
      }

      value = value - 1;
      //console.log(`${value} is the value after fixing`)
      document.getElementById('newDayBtn').value = value;
  }
  //activatePlacesSearch();
  

};

function addNewAct(day_num) {
  var activityNumber = incrementActivity();

  console.log( "This is the activity number" + activityNumber);

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
  //activatePlacesSearch();

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

function general_data() {
  var tourTitle = document.getElementById("title").value;
  var tourCategory = document.querySelector('input[name="category"]:checked').value;
  var season = document.querySelector('input[name="season"]:checked').value;
  var country = document.getElementById("country-select").value;
  var price = document.getElementById("price").value;
  var imageURL = document.getElementById("fileName").value;

  console.log("------------");
    console.log(itineraryOwner);
    console.log(tourTitle);
    console.log(tourCategory);
    console.log(country);
    console.log(price);
    console.log(imageURL);
    console.log(season);
    //console.log(generaldetails);
    console.log("------------");

  //call insertion function here
  sendItinerary(itineraryOwner,tourTitle,tourCategory,country,price,imageURL,season);

  // getLatestId();
}

async function sendItinerary(itineraryOwner,tourTitle,tourCategory,country,price,imageURL,season){
  var itineraryid = 0;
  let HasApproved = false;
  var date = new Date();
  var datetimecreated = date.getDate();

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

  // // Creating a XHR object
  // let xhr = new XMLHttpRequest();
  // let url = "http://localhost:5010/createitinerary";
  // // open a connection
  // //xhr.open('GET', `${url}/${itineraryid}/${itineraryOwner}/${tourTitle}/${tourCategory}/${country}/${price}/${imageURL}/${season}/${datetimecreated}/${HasApproved}`, false);
  // xhr.open('POST', url, false);
  // xhr.setRequestHeader("Content-Type", "application/json");
  // // Set the request header i.e. which type of content you are sending
  // //xhr.setRequestHeader("Content-type", "application/json");
  // // Create a state change callback
  // xhr.onreadystatechange = function () {
  //     if (xhr.readyState === 4 && xhr.status === 200) {
  //         // Print received data from server
  //         result.innerHTML = this.responseText;
  //     }
  // };
  // // Converting JSON data to string
  // //var data = JSON.stringify({ "itineraryid": itineraryid,"Itineraryowner": itineraryOwner, "tourtitle": tourTitle, "tourcategory": tourCategory, "country": country, "price": price, "thumbnail": imageURL, "season": season,"datetimecreated":datetimecreated, "HasApproved":HasApproved });
  // // Sending data with the request
  // xhr.send(JSON.stringify(data));
  console.log("test");
  // $(async() => {           
    // Change serviceURL to your own
    var serviceURL = "http://localhost:5010/createitinerary";
    
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
  
  // });
  // await fetch("http://localhost:5010/createitinerary",
  //   {
  //       method: "POST",
  //       headers: {
  //           "Content-type": "application/json"
  //       },
  //       body: JSON.stringify(data)
  //   })
  //   .then (response => response.json())
  //   .then(data => {
  //       console.log(data);
        
  //       } // switch
  //   )


  //   .catch(error => {
  //       console.log("Problem in adding to cart. " + error);
  //   })
}

function getLatestId() {
  var url = "http://localhost:5010/itinerary/latest";
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

  //details_data();
  
}


function details_data(itinerary_id){
  var total_num_days = document.querySelectorAll('[id^="Day"]');
  console.log(total_num_days);
  console.log(total_num_days.length);

  var currentDay = 1;

  for (day of total_num_days) {
      InsertEachDay(day, currentDay,itinerary_id);
      currentDay += 1;
  };
}

function InsertEachDay(day, currentDay,itinerary_id) {
    console.log("------------");
    console.log(currentDay);
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

        console.log(location);
        console.log(activity);
        console.log(activitynumber);
        console.log(description);
        console.log(starttime);
        console.log(endtime);
        console.log("------------");
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
  let url = "http://localhost:5010/createitinerary/details";
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