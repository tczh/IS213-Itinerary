checkoutURL = "http://localhost:8000/api/v1/allcartitems";
itineraryURL = "http://localhost:8000/api/v1/individualitinerary";
deleteCartURL = "http://localhost:8000/api/v1/delcart";
var email;

function onLoadData(){
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var emails = urlParams.get("email");
    sessionStorage.setItem('email', emails);
    email = sessionStorage.getItem('email');
    getAll(email);
}

function getAll(emailAddr){

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
    var tableHtml = ``;
    var cart = response_json["data"]["cartItems"];
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
    document.getElementById('itemization').innerHTML = tableHtml;
    document.getElementById('total_number').innerHTML = count;
    document.getElementById('total_amount').innerHTML = "TotalPrice:" + totalPrice;
}
function retrieveAllCart(obj){
    var response_json = JSON.parse(obj.responseText);
    var tableHtml = ``;
    var cart = response_json["data"]["cartItems"];
    sessionStorage.setItem("cart",cart);
    var retrieveEmail = sessionStorage.getItem('email');
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
    var carts = sessionStorage.getItem('cart');
    for(items of cart){
        count += 1;
        totalPrice += items['price'];
        tableHtml += `
        <div class="item">
            <div class="description">${count}</div>
            <div class="description">${items['tourtitle']}</div>
            <div class="description">${items['price']}</div>
            <div class="description"><button class='btn btn-danger rounded-3' data-toggle="modal" data-target="#exampleModalLong" onClick='deleteItinerary(${items['itineraryID']}, ${items['cartID']})'><i class="fa fa-close"></i></button></div>
        </div>`;
    }
    sessionStorage.setItem('quantity', count);
    var counting = sessionStorage.getItem('quantity');

    document.getElementById('itemization').innerHTML = tableHtml;
    document.getElementById('total_amount').innerHTML = "Total: SGD $" + totalPrice;
    sessionStorage.setItem('prices', totalPrice);
    var form = document.getElementById("submit");
    form.addEventListener("click", function(event) {

    var prices = sessionStorage.getItem('prices')
    sessionStorage.setItem("emails", email);
    processCheckout(prices, email, cartId);
    });

}

function deleteItinerary(itineraryID,cartID){
    var email = sessionStorage.getItem("email");
    var deleteURL = "http://localhost:5015/deleteAll";
    var data = {"itineraryID": itineraryID, "cartID": cartID}
    // Change serviceURL to your own
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            AllWindowsRedirect(email);
            
        }
    }
    request.open("POST",deleteURL, false);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(data));
    

}
function AllWindowsRedirect(email){
    var url = "Checkout.php?email=" + email;
    location.href = url;
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
    var parameterData = {
        cartID: cartId,
        emailAddr: email,
        totalPrice: price
    };

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 201) {
            var data = JSON.parse(this.responseText);

            itemsArr = data["data"]["payment_result"]["data"]["paymentItems"];
            var count_of_itinerary = itemsArr.length;

            sessionStorage.setItem("cartId", cartId);
            sessionStorage.setItem("totalPrice", price);
            sessionStorage.setItem("paymentId", data["data"]["payment_result"]["data"]["paymentID"]);
            window.location.href = "payment.php";
        }
    }
    request.open("POST", paymentURL, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(parameterData));
}