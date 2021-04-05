// A reference to Stripe.js
var apiKey = 'pk_test_51IY8rSKA7uVreypXmCCcFfkC5jLtkNmHOqi1pqBhLVET7XuOCaeA1P4H1sehvk28D5J7XrHoXclkp8k5ZOUz9gBT00lcZUHboS';
var stripe;

var cartData = {
    totalPrice: $_POST[price],
    key: apiKey,
    currency: "sgd"
};

var secondData = {
    paymentID: $_POST[paymentId],
    emailAddr: "yuhao97@live.com", //document.getElementById("email").innerText;
    fullName: "Neo Yu Hao" // If there would be welcome, .
};


//document.getElementById("quantity").innerText = $_POST[quantity];
//document.getElementById("price").innerText = $_POST[totalPrice]
$(async() => {           
    // Change serviceURL to your own
    var serviceURL = "http://localhost:5300/purchase_itinerary/purchase";
    
    try {
        const response =
            await fetch(
                serviceURL, { 
                    method: 'POST',
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify(cartData) 
                }
            );
            const result = await response.json();
            var paymentObject = setupElements(result.paymentIntent);
            
            // Handle form submission.
            var form = document.getElementById("submit");
            form.addEventListener("click", function(event) {
                event.preventDefault();
                // Initiate payment when the submit button is clicked
                pay(paymentObject["stripe"], paymentObject["card"], paymentObject["clientSecret"]);  
                updateDatabase();       
        });
    } catch (error) {
        // Errors when calling the service; such as network error, 
        // service offline, etc
        console.log("Cannot connect!");
    } // error
});

function updateDatabase() {          
    paymentURL = "http://localhost:5300/purchase_itinerary/update";

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data["code"])
            if (data["code"] == "201") {
                $('#paymentModal').modal('show');
            }
        }
    }
    request.open("POST", paymentURL, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(secondData));
}

var setupElements = function(data) {
    stripe = Stripe(data.publishableKey);
    /* ------- Set up Stripe Elements to use in checkout form ------- */
    var elements = stripe.elements();
    var style = {
        base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
              color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };

    var card = elements.create("card", {style: style, hidePostalCode: true});
    card.mount("#card-element");

    return {
        stripe: stripe,
        card: card,
        clientSecret: data.clientSecret
    };
};

/*
 * Calls stripe.confirmCardPayment which creates a pop-up modal to
 * prompt the user to enter extra authentication details without leaving your page
 */
var pay = function(stripe, card, clientSecret) {
    // Initiate the payment.
  // If authentication is required, confirmCardPayment will automatically display a modal
    stripe
        .confirmCardPayment(clientSecret, {
            payment_method: {
              card: card
            }
        })
        .then(function(result) {
            if (result.error) {
                // Show error to your customer
                console.log("payment failed!")
            } else {
                // The payment has been processed!
                console.log("payment success!")
            }
        });
};