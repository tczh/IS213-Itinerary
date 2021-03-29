// A reference to Stripe.js
var apiKey = 'pk_test_51IY8rSKA7uVreypXmCCcFfkC5jLtkNmHOqi1pqBhLVET7XuOCaeA1P4H1sehvk28D5J7XrHoXclkp8k5ZOUz9gBT00lcZUHboS';
var stripe;
var paymentObject; 

var orderData = {
    totalPrice: 200,
    key: apiKey,
    currency: "sgd"
};

var secondData = {
    paymentID: 2
};

$(async() => {           
    // Change serviceURL to your own
    var serviceURL = "http://localhost:5016/createPaymentIntent";

    try {
        const response =
            await fetch(
                serviceURL, { 
                    method: 'POST',
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify(orderData) 
                }
            );
            const result = await response.json();
            var paymentObject = setupElements(result);
            
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
    // Change serviceURL to your own
    paymentURL = "http://localhost:5016/payment";

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);
        }
    }
    request.open("PUT", paymentURL, true);
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

    var card = elements.create("card", { style: style });
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

/* ------- Post-payment helpers ------- */

/* Shows a success / error message when the payment is complete */
var orderComplete = function(clientSecret) {
  stripe.retrievePaymentIntent(clientSecret).then(function(result) {
    var paymentIntent = result.paymentIntent;
    var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);

    document.querySelector(".sr-payment-form").classList.add("hidden");
    document.querySelector("pre").textContent = paymentIntentJson;

    document.querySelector(".sr-result").classList.remove("hidden");
    setTimeout(function() {
      document.querySelector(".sr-result").classList.add("expand");
    }, 200);

    changeLoadingState(false);
  });
};

var showError = function(errorMsgText) {
  changeLoadingState(false);
  var errorMsg = document.querySelector(".sr-field-error");
  errorMsg.textContent = errorMsgText;
  setTimeout(function() {
    errorMsg.textContent = "";
  }, 4000);
};













