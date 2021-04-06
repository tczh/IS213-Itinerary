checkoutURL = "http://localhost:5015/allcartitems";
itineraryURL = "http://localhost:5010/individualitinerary";
deleteCartURL = "http://localhost:5015/delcart";
email = "elvis.leong.2019@sis.smu.edu.sg"
function onLoadData(){

    email = sessionStorage.getItem('email');
    email = "elvis.leong.2019@sis.smu.edu.sg"
    getAll(email);
}

function getAll(emailAddr){
    
    dataSend = JSON.stringify({"emailAddr": "elvisleong.2019@sis.smu.edu.sg" })
    console.log(dataSend)        
    // Change serviceURL to your own
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            retrieveAllCart(this);
        }
    }
    request.open("GET", (`${checkoutURL}/${emailAddr}`), false);
    request.setRequestHeader("Content-type", "application/json");
    request.send();

}
function retrieveAllCarts(response_json){
    console.log(response_json);
    var tableHtml = ``;
    var cart = response_json["data"]["cartItems"];
    console.log(cart + "in");
    var count = 0;
    var totalPrice = 0;
    tableHtml += `
    <table>
        <tr class="item">
            <th>Cart No</th>
            <th>Tour Title</th>
            <th>Price</th>
            <th><input type="checkbox" class="allCarts" onclick='selectedAll()'></th>
        </tr>`;
    /*tableHtml += `
    <div class="container" style="margin-top:10px; background-color:"white">
        <div class="row" style="border-bottom: gray solid 1px ;">
        <div class="col-8" style="padding: 10px; ">
        <input type="checkbox" class="store" id="${email}" onclick="selected()" value="0">&nbsp&nbsp&nbsp
        <label for="${response_json["data"]["cartID"]}"><i> <div id='retrieveName'></div></i></label>
        </div>
    </div>
    <div class="row">
    <div class="col-3" style="padding: 10px; overflow: hidden;">
        <input type="checkbox" class="${response_json["data"]["cartID"]} id=`;
    */
    for(items of cart){
        count += 1;
        totalPrice += items['price'];
        tableHtml += `
        <div class="item">
            <div class="buttons">
                <span class="delete-btn"></span>
                <span class="like-btn"></span>
            </div>

            <div class="image">
                <span>${items['cartNo']}</span>
            </div>
            <div class="description">
                <span>${items['tourtitle']}</span>
            </div>
            <div class="quantity">
                <input type="text" name="name" value="1">
            </div>
            <div class="total-price">${items['price']}</div>
        </div>
        `;
    }
    console.log(tableHtml);
    document.getElementById('itemization').innerHTML = tableHtml;
    document.getElementById('total_number').innerHTML = count;
    document.getElementById('total_amount').innerHTML = "TotalPrice:" + totalPrice;
}
function retrieveAllCart(obj){
    var response_json = JSON.parse(obj.responseText);
    console.log(response_json);
    var tableHtml = ``;
    var cart = response_json["data"]["cartItems"];
    sessionStorage.setItem("cart",cart);
    var emails = sessionStorage.setItem('emails', email);
    var retrieveEmail = sessionStorage.getItem('emails');
    console.log(retrieveEmail);
    var cartId = response_json["data"]["cartID"];
    var count = 0;
    var totalPrice = 0;
    tableHtml += `
    
        <div class="item" style:"border-bottom:1px solid #E1E8EE;">
            <div class="description">Cart No</div>
            <div class="description">Tour Title</div>
            <div class="description">Price (SGD)</div>
            <div class="description">Delete</div>
        </div>`;
    /*tableHtml += `
    <div class="container" style="margin-top:10px; background-color:"white">
        <div class="row" style="border-bottom: gray solid 1px ;">
        <div class="col-8" style="padding: 10px; ">
        <input type="checkbox" class="store" id="${email}" onclick="selected()" value="0">&nbsp&nbsp&nbsp
        <label for="${response_json["data"]["cartID"]}"><i> <div id='retrieveName'></div></i></label>
        </div>
    </div>
    <div class="row">
    <div class="col-3" style="padding: 10px; overflow: hidden;">
        <input type="checkbox" class="${response_json["data"]["cartID"]} id=`;
    */
    var carts = sessionStorage.getItem('cart');
    for(items of cart){
        count += 1;
        totalPrice += items['price'];
        tableHtml += `
        <div class="item">
            <div class="description">${items['cartNo']}</div>
            <div class="description">${items['tourtitle']}</div>
            <div class="description">${items['price']}</div>
            <div class="description"><button class='btn rounded-3' data-toggle="modal" data-target="#exampleModalLong" onClick='deleteItinerary(${items['itineraryID']}, ${items['cartID']})'><i class="fa fa-close"></i></button></div>
        </div>`;
    }
    // tableHtml += `
    // </table>`;
    console.log(tableHtml); 
    sessionStorage.setItem('quantity', count);
    var counting = sessionStorage.getItem('quantity');
    console.log(counting);

    document.getElementById('itemization').innerHTML = tableHtml;
    // document.getElementById('total_number').innerHTML = count;
    document.getElementById('total_amount').innerHTML = "Total: SGD $" + totalPrice;
    sessionStorage.setItem('prices', totalPrice);
    //document.getElementById('checkout').innerHTML = "<button "
    var form = document.getElementById("submit");
    form.addEventListener("click", function(event) {

    var prices = sessionStorage.getItem('prices')
    var emailAddr = sessionStorage.getItem('emails');
    processCheckout(prices, emailAddr, cartId);
    });

}

function retrieveItinerary(itineraryID, tableHtml){
       
    // Change serviceURL to your own

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            retrieveitineraryID(this, itineraryID, tableHtml)
        }
    }
    request.open("GET", (`${itineraryURL}/${itineraryID}`), false);
    request.setRequestHeader("Content-type", "application/json");
    request.send();
}
function deleteItinerary(itineraryID,cartID){
    console.log(itineraryID);
    console.log(cartID);
    var deleteURL = "http://localhost:5015/deleteAll";
    var data = {"itineraryID": itineraryID, "cartID": cartID}
    // Change serviceURL to your own
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Successfully deleted");
        }
    }
    request.open("POST",deleteURL, false);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(data));
    

}
    

function select_all(){
    var all_itineraries = document.getElementById("all_itineraries");
    var all_checkbox = document.getElementsByTagName("input");
    
    if(all_itineraries == true){
        for(var checkbox of all_checkbox){
            checkbox.checked = true;
        }
    }
    for(var checkbox of all_checkbox){
        checkbox.checked = false;
    }
}
function checkout_button(){
    //Link to Yuhao's page
}
function deletebyItinerary(itineraryID){
    var checkboxes = document.getElementsByName("individualcheck");
    if(checkbox == true){
        for(var check of checkboxes){
            check.checked = true;

        }
    }
    else{
        for(var check of checkboxes){
            check.checked = false;
        }
    }

}
function processCheckout(price, email, cartId) {
    var paymentURL = "http://localhost:5300/purchase_itinerary";
    //console.log(price,email,cartId);
    var parameterData = {
        cartID: cartId,
        emailAddr: email,
        totalPrice: price
    };

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 201) {
            var data = JSON.parse(this.responseText);

            console.log(data);
            itemsArr = data["data"]["payment_result"]["data"]["paymentItems"];
            var count_of_itinerary = itemsArr.length;

            sessionStorage.setItem("cartId", cartId);
            sessionStorage.setItem("totalPrice", price);
            //sessionStorage.setItem("quantity", count_of_itinerary);
            sessionStorage.setItem("paymentId", data["data"]["payment_result"]["data"]["paymentID"]);
            window.location.href = "payment.php";
        }
    }
    request.open("POST", paymentURL, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(parameterData));
}